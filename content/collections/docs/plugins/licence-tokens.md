---
id: 01m6e4wsfd46f027c3w9j613sfj5
title: Licence tokens
position: 8
group: 'Build'
description: A paid plugin's licence is a signed token that a site checks by itself. The format is public, and you can verify one with a few lines and no Lettern.
---
The Lettern core has no licence. A paid plugin's licence key is a [PASETO v4.public](https://github.com/paseto-standard/paseto-spec/blob/master/docs/01-Protocol-Versions/Version4.md) token: Ed25519 over the message, footer and an implicit assertion. A site verifies it locally, with sodium when PHP has it and OpenSSL otherwise, so there is no activation server and nothing to phone. The token grants nothing except a match on its own domains.

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
| `iat` | When it was signed. A refresh re-signs, so it is also trusted server time. |
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

A plugin sold elsewhere declares its issuer, with no code. It gets a token source and a state of its own, separate from anything sold through the store. A key pasted on the **Licence** screen finds its issuer by its key id, and `refresh` is where the site keeps it current.

```json
"extra": { "cms": { "license": {
  "product": "acme/forms", "paid": true, "major_released": "2027-01-10",
  "issuer": { "id": "acme", "family": "acme-plugins", "trust": "resources/trust.json", "refresh": "https://acme.example/api/license/v1" }
} } }
```

Its token goes in `CMS_LICENSE_ACME` or `config/licenses/acme.key`. `major_released` is compared with `upd`: a licence never reads a clock to decide whether a version is covered.

A plugin may not change what visitors get based on its licence state. `LicenseService::state()` answers `UNKNOWN` on public requests, and a public request doesn't load the licence code at all.

## Refresh

A signed-in admin's visit asks at most once a day, in the background, with a 3-second limit:

```json
POST {license endpoint}/refresh
{ "lid": "01JB...", "rev": 12, "url": "https://www.example.com", "client": { "cms_version": "1.2.0", "php_version": "8.4.3" } }
```

The answer is `200 {"token":"v4.public..."}`, always freshly signed. It counts only if it verifies, for the same `lid`, at the same `rev` or higher. Anything else, a 404, a 429, a server that is gone, changes nothing but a line in the state file.

## Keys

Three kinds of key do the work, and each may sign only what its role says:

| Key | Signs | Kept |
|---|---|---|
| Root | The trust file, nothing else | Offline |
| Release (`release`, and `preview` for 0.x only) | Packages, the update list, catalogs | The release pipeline |
| Licence (`license`) | Licence tokens, nothing else | The seller's site |

A leaked licence key can forge banners, never code. It is revoked with a date: tokens signed before it keep working, offline too. `resources/trust/trust.json` in `letterncms/cms` lists the keys, signed by the root; a new one is accepted only if a current root signed it and its version is higher. A file marked `"dev": true` has public keys and counts only when `APP_ENV` is `local` or `testing`.
