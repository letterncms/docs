---
id: 01m6e4wsfd46f027c3w9j613sfj5
title: Licence tokens
position: 10
description: A paid plugin's licence key is a signed token that a site checks by itself. The format is public, so you can issue and verify your own.
---
Lettern itself needs no licence. A paid plugin does, and its licence key is a signed token: the site checks the signature by itself, so there's no activation server and nothing to phone home. If you sell a plugin, this page shows the format, how to verify a token, and how to issue your own.

## What a token holds

A licence key is a [PASETO v4.public](https://github.com/paseto-standard/paseto-spec/blob/master/docs/01-Protocol-Versions/Version4.md) token: Ed25519 over the message, footer and an implicit assertion. A site verifies it locally, with sodium when PHP has it and OpenSSL otherwise. The token grants nothing except a match on its own domains.

Its message is JSON like this:

```json
{
  "lid": "01JB...",
  "iat": "2026-11-02T10:00:00Z",
  "rev": 12,
  "dom": ["example.com", "example.de", "=acme.sharedhost.com"],
  "items": [
    { "p": "acme/forms", "ed": "pro", "st": "active", "upd": "2027-11-02", "trm": null },
    { "p": "acme/shop", "ed": "site", "st": "active", "upd": "2029-11-02", "trm": null }
  ]
}
```

| Claim | Meaning |
|---|---|
| `lid` | Licence id. Never a name or an email: tokens end up in git. |
| `iat` | When it was signed. A refresh re-signs, so it's also trusted server time. |
| `rev` | Only ever goes up, on any change to the claims. The highest for a `lid` wins. |
| `dom` | `example.com` covers the apex, every subdomain and subfolder. `=host` covers that host alone. Required. |
| `items[].p` | Product id, equal to the package name. |
| `items[].ed` | Edition, an opaque string. |
| `items[].st` | `active`, `refunded`, `charged_back` or `revoked`. |
| `items[].upd` | Majors released on or before this date are covered. `null` means no limit. |
| `items[].trm` | When a term ends, for plans that have one. Otherwise `null`. |
| `items[].tgr` | Days of grace after `trm`. |

The footer is `{"kid":"<key id>"}`, naming a key of role `license` in the trust file. The implicit assertion is `cms-license:1:<family>`, where the family comes from the trust file. Test mode appends `-test`, so a test token fails on a live site. Tokens over 4 KB are refused before parsing.

## Verify one anywhere

Anything that can check Ed25519 can check a token. `Cms\Modules\License\Token\Paseto` is about 40 lines and depends on nothing, and it also signs: a seller needs nothing else from Lettern to issue tokens.

## Sell your own plugin

A plugin sold outside the store declares its issuer in `composer.json`, with no code:

```json
"extra": { "cms": { "license": {
  "product": "acme/forms", "paid": true, "major_released": "2027-01-10",
  "issuer": { "id": "acme", "family": "acme-plugins", "trust": "resources/trust.json", "refresh": "https://acme.example/api/license/v1" }
} } }
```

| Key | Meaning |
|---|---|
| `product` | The product id in the token's `items[].p`. |
| `paid` | It needs a licence. |
| `major_released` | When this major version came out. It's compared with `upd`: a licence never reads a clock to decide whether a version is covered. |
| `issuer.id` | The issuer's name on this site. |
| `issuer.family` | The family in the implicit assertion. |
| `issuer.trust` | Your trust file, inside the package. |
| `issuer.refresh` | Your licence endpoint, where the site keeps its token current. |

The plugin gets a token source and a state of its own, separate from anything sold through the store. A key pasted on the **Licence** screen finds its issuer by its key id. Its token goes in `CMS_LICENSE_ACME` or `config/licenses/acme.key`.

::: callout {"props":{"tone":"warning","text":"A plugin may not change what visitors get based on its licence state. <code>LicenseService::state()</code> answers <code>UNKNOWN</code> on public requests, and a public request doesn't load the licence code at all."}}
:::

## Refresh

A signed-in admin's visit asks at most once a day, in the background, with a 3-second limit:

```json
POST {license endpoint}/refresh
{ "lid": "01JB...", "rev": 12, "url": "https://www.example.com", "client": { "cms_version": "1.2.0", "php_version": "8.4.3" } }
```

Answer `200 {"token":"v4.public..."}`, always freshly signed. It counts only if it verifies, for the same `lid`, at the same `rev` or higher. Anything else (a 404, a 429, a server that's gone) changes nothing but a line in the state file.

## Keys

Three kinds of key do the work, and each may sign only what its role says:

| Key | Signs | Kept |
|---|---|---|
| Root | The trust file, nothing else | Offline |
| Release (`release`, and `preview` for 0.x only) | Packages, the update list, catalogs | The release pipeline |
| Licence (`license`) | Licence tokens, nothing else | The seller's site |

A leaked licence key can forge banners, never code. It's revoked with a date: tokens signed before it keep working, offline too.

`resources/trust/trust.json` in `letterncms/cms` lists the keys, signed by the root. A new one is accepted only if a current root signed it and its version is higher. A file marked `"dev": true` has public keys and counts only when `APP_ENV` is `local` or `testing`.
