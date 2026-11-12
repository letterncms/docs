---
id: 01m6e4x7n2q8vd5k0r3t9b6hza
title: Store protocol
position: 12
description: A plugin store is a few signed files. Anyone can run one, and a site trusts the signatures, not the server.
---
**Plugins** reads a plugin store: a handful of JSON files and zips. Anyone can run one, and every site can use it. A site trusts what's signed, not the server it came from, so a store can't slip in a package it didn't sign.

A store that sells things also needs something to take the money and issue [licenses](/plugins/license-tokens). The client neither knows nor cares how it does that: this page is all a site relies on.

## The files

Everything lives under `/api/store/v1`:

| Path | What it is |
|---|---|
| `index.json` | `{name, api: 1, trust_url, catalog_url}` |
| `trust.json` | The store's trust file |
| `catalog.json` | The signed catalog |
| `items/{vendor}/{name}.json` | Optional detail: `{description_html, gallery, requirements, docs_url, repository_url, releases, operator}`. Unsigned, so a site cleans its HTML and drops images from other origins |
| `download/{vendor}/{name}/{version}` | The zip |

## The catalog

The catalog lists every package with its versions. It's an envelope, `{"payload": "<base64url of the exact bytes>", "sigs": [{"kid": "...", "sig": "..."}]}`, signed by a `release` key over `cms-signed:1:cms-catalog\n<bytes>`. Its version only goes up, and a client refuses one lower than it has seen.

The payload:

```json
{
  "type": "cms-catalog", "version": 412, "issued": "2027-01-10T10:00:00Z", "expires": "2027-02-09T10:00:00Z",
  "store": "https://store.example",
  "items": [{
    "package": "acme/forms", "type": "plugin", "title": "Acme Forms", "summary": "...",
    "categories": ["Forms"], "glyph": "textbox", "featured": false,
    "pricing": "paid", "first_party": false, "author": { "name": "Acme", "url": "https://..." },
    "listing_url": "https://store.example/store/acme-forms", "dev_download": false,
    "versions": [{
      "version": "2.1.0", "released_at": "2027-01-08T09:00:00Z", "sha256": "...", "size": 482133,
      "url": "https://store.example/api/store/v1/download/acme/forms/2.1.0",
      "requires": { "core": "^1.2", "php": ">=8.4", "ext": ["zip"], "packages": { "letterncms/seo": "^1.0" } },
      "capabilities": ["network"], "security": false, "fixes": null, "first_party": false,
      "kid": "rel-2026", "sig": "..."
    }]
  }],
  "blocked": [{ "package": "bad/thing", "versions": "<1.4.2", "severity": "critical", "advisory": "https://..." }],
  "yanked": [{ "package": "acme/forms", "version": "2.0.1", "reason": "Breaks saving" }]
}
```

Items come in the store's own order, and a site keeps it for **Most Popular**. `glyph` names an icon from the set the admin draws, so a listing needs no picture to fetch; `featured` puts it first in the list of plugins. Neither changes the order.

### The detail

The detail fills the plugin's own page in **Plugins**:

```json
{
  "description_html": "<h2>Build it where you build pages</h2><p>...</p>",
  "gallery": [{ "url": "https://store.example/media/forms-builder.webp", "alt": "A booking form in the builder." }],
  "requirements": ["A Brevo account with a verified sender domain"],
  "docs_url": "https://...", "repository_url": "https://github.com/...",
  "releases": [{ "version": "2.1.0", "released_at": "2027-01-08T09:00:00Z", "notes": "Added\n• Maps for every page.", "security": false }],
  "operator": "Acme BV"
}
```

A site shows only pictures from the store's own origin and only `http` and `https` links. `screenshots`, a list of addresses alone, is still read from stores that send no `gallery`.

### Each version is signed too

Each version carries its own signature, over:

```
cms-signature-v1\n<package>\n<version>\n<sha256>\n<released_at>\n
security=<0|1>;fixes=<range>;first_party=<0|1>;capabilities=<sorted,comma,list>\n
```

So a store can't serve one signed zip as another, relabel it as a security fix, or hide a capability.

## Paid downloads

A site only offers **Install** for a paid package when its license names the package and covers this host. Otherwise it offers the listing, and a place to paste the key once it's bought (the `packages/add-key` ability).

The download then carries the token, and the store has the last word:

```
GET {url}?site_host=example.com
X-Cms-License: v4.public...
```

- Answer `200` with the zip, or `403 {"code":"not_entitled"}`.
- Security versions go to any token that names the package, even with its update window over.
- On a local or staging host, a package with `dev_download: true` is asked for with `?use=nonpublic`.

## What a site refuses

A site checks everything before it installs anything. It refuses:

- A hash or signature that doesn't match, a key of the wrong role, or a revoked one.
- A version off the store's own origin, or a version in `blocked`.
- An expired catalog: more than 14 days past `expires`.
- Any zip with a symlink, a path outside its one top folder, a hidden file, a `.phar`, two names differing only by case, an unreasonable unpacked size, or PHP that doesn't parse.

Only the default store may provide the `cms/` vendor or the `Cms\` namespace, and a package updates only from the store it came from.

## Composer

A store also answers as a Composer repository at `/composer`, so a site managed with Composer installs what it sells the same way as anything else:

```bash
composer config repositories.store composer https://store.example/composer
composer config http-basic.store.example example.com "<license key>"
composer require acme/forms
```

Free packages need no login. For a paid one, the username is the site's domain and the password is its license key, and the store applies the same rules as for a paid download.
