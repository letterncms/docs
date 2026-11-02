---
id: 01m5wnc9yc4k7e56k93cm6cr86
title: Security
position: 2
description: How Lettern protects sites, accounts and content — and the switches you have for locking it down further.
---
## Accounts

- Passwords are hashed with Argon2id. Sign-in is rate limited per account and per address.
- Two-factor authentication with any authenticator app, with one-time recovery codes. Enable it under **Account**; it is also required on the agent consent screen when switched on.
- Session cookies are HTTP-only and SameSite; every admin request carries a CSRF token. A site on its own port (`localhost:8003`) uses cookie names of its own, as browsers share cookies across ports.

## API tokens and agents

- Personal access tokens (`cms_…`) are shown once and stored only as a hash. Give them **scopes** and an **expiry**; each shows when it was last used.
- OAuth for agents uses PKCE (S256 only), short-lived access tokens and rotating refresh tokens; you approve every client on a consent screen.
- Abilities that could take over an account — creating tokens, changing passwords or two-factor settings, managing users and roles — are never available to agents or the assistant.
- The assistant asks before deleting anything, treats site content and visitor-written text as data, never as instructions, and once a chat has read such content, asks before anything but saving a draft. Chats are private to their owner and encrypted at rest.

## Every action

All changes go through [abilities](/agents/abilities): input is validated against a schema, permissions are checked (including per collection), and the change is written to the **audit log** with who, through which channel and from where. Secrets in the input are redacted in the log.

## Content and uploads

- Rich text is cleaned with an allow-list HTML sanitizer. Raw HTML blocks need the `blocks.html` permission; the site's custom JavaScript needs `site.code`.
- Interactions built in the block workspace run on Alpine's CSP build: expressions can read and change the element's own state but cannot reach `window`, `document`, other globals or arbitrary functions, and every script setting is checked when it is saved. Style values that could escape CSS are refused.
- Links and sources that come from data or from an interaction — a bound `href` or `src` — only take `http(s)`, relative, `#`, `?`, `mailto:` and `tel:` addresses; a `javascript:` URL in a field never reaches the page.
- Uploads are identified by their contents, not their names; SVGs are stripped of scripts and event handlers; photo metadata is removed. `public/` never executes PHP.
- Fetching remote files (media import) refuses private and internal network addresses, re-checks every redirect and limits size.
- Paths are resolved safely everywhere — no `../` escapes.
- Form submissions pass a honeypot, a time trap, rate limits and an origin check; CSV exports neutralize spreadsheet formulas.

## Headers

Every response sets `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `Cross-Origin-Opener-Policy` and `X-Frame-Options`, plus HSTS over HTTPS. The admin shell has a strict content security policy with a per-request nonce; API responses are never cached.

## Hardening switches

| Setting | Effect |
|---|---|
| `CMS_ALLOW_FILE_MODS=false` | No installing, updating or deleting plugin files from the admin. |
| `CMS_INSTALL_TOKEN` | The web installer requires this token. |
| `APP_DEBUG=false` | Never show error details on a live site. |

Static publishing helps too: visitors get files, so most requests never reach PHP or the database.
