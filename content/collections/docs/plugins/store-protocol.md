---
id: 01m6e4x7n2q8vd5k0r3t9b6hza
title: Store protocol
position: 9
group: 'Build'
description: A store is a few signed files. Anyone can run one, and a site trusts the signatures rather than the server.
---
The Store tab in **Modules** works on every site, with no commerce plugin. It reads these files. A store that sells things also needs something to take the money and issue licences. The paid commerce plugin [does all of this](/operations/commerce#run-a-store), but the client neither knows nor cares.

| Path under `/api/store/v1` | What it is |
|---|---|
| `index.json` | `{name, api: 1, trust_url, catalog_url}` |
| `trust.json` | The store's trust file |
| `catalog.json` | The signed catalog |
| `items/{vendor}/{name}.json` | Optional detail: `{description_html, screenshots, operator}`. Unsigned, so a site cleans its HTML and drops images from other origins |
| `download/{vendor}/{name}/{version}` | The zip |

## Catalog

An envelope `{"payload": "<base64url of the exact bytes>", "sigs": [{"kid": "...", "sig": "..."}]}`, signed by a `release` key over `cms-signed:1:cms-catalog\n<bytes>`. Its version only goes up, and a client refuses one lower than it has seen.

```json
{
  "type": "cms-catalog", "version": 412, "issued": "2027-01-10T10:00:00Z", "expires": "2027-02-09T10:00:00Z",
  "store": "https://store.example",
  "items": [{
    "package": "acme/forms", "type": "plugin", "title": "Acme Forms", "summary": "...",
    "pricing": "paid", "first_party": false, "author": { "name": "Acme", "url": "https://..." },
    "listing_url": "https://store.example/store/acme-forms", "dev_download": false,
    "versions": [{
      "version": "2.1.0", "released_at": "2027-01-08T09:00:00Z", "sha256": "...", "size": 482133,
      "url": "https://store.example/api/store/v1/download/acme/forms/2.1.0",
      "requires": { "core": "^1.2", "php": ">=8.4", "ext": ["zip"], "packages": { "letterncms/blocks": "^1.0" } },
      "capabilities": ["network"], "security": false, "fixes": null, "first_party": false,
      "kid": "rel-2026", "sig": "..."
    }]
  }],
  "blocked": [{ "package": "bad/thing", "versions": "<1.4.2", "severity": "critical", "advisory": "https://..." }],
  "yanked": [{ "package": "acme/forms", "version": "2.0.1", "reason": "Breaks saving" }]
}
```

Each version carries its own signature, over:

```
cms-signature-v1\n<package>\n<version>\n<sha256>\n<released_at>\n
security=<0|1>;fixes=<range>;first_party=<0|1>;capabilities=<sorted,comma,list>\n
```

So a store can't serve one signed zip as another, relabel it as a security fix, or hide a capability. `tools/sign.php` in [letterncms/dev](https://github.com/letterncms/dev) writes all of this.

## Paid downloads

A site only offers **Install** for a paid package when its licence names the package and covers this host; otherwise it offers the listing, and a place to paste the key once it's bought (the `packages/add-key` ability). The download then carries the token, and the store has the last word:

```
GET {url}?site_host=example.com
X-Cms-License: v4.public...
```

Answer `200` with the zip, or `403 {"code":"not_entitled"}`. Security versions go to any token that names the package, even with its update window over. On a local or staging host, a package with `dev_download: true` is asked for with `?use=nonpublic`.

## What a site refuses

A hash or signature that doesn't match, a key of the wrong role or a revoked one, a version off the store's own origin, a version in `blocked`, an expired catalog (more than 14 days past `expires`), and any zip with a symlink, a path outside its one top folder, a hidden file, a `.phar`, two names differing only by case, an unreasonable unpacked size, or PHP that doesn't parse. Only the default store may provide the `cms/` vendor or the `Cms\` namespace, and a package updates only from the store it came from.

## Composer

A store also answers as a Composer repository at `/composer`, so a site managed with Composer installs what it sells the same way as anything else:

```bash
composer config repositories.store composer https://store.example/composer
composer config http-basic.store.example example.com "<licence key>"
composer require acme/forms
```

Free packages need no login. For a paid one, the username is the site's domain and the password is its licence key, and the store applies the same rules as for a paid download.

## Try it locally

`php tools/dev-store.php` in [letterncms/dev](https://github.com/letterncms/dev) writes a stand-in store signed with the public development keys, with one free and one paid plugin. Its header says how to serve it and point a site with `APP_ENV=local` at it.
