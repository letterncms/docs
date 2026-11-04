---
id: 01m5wnc9yc4k7e56k93cm6cr86
title: Security
position: 4
description: Lettern keeps sites, accounts and content safe by default. Here's what it does, and the few things worth switching on.
---
Lettern is safe out of the box: published pages are plain files, every change is checked and logged, and uploads and forms are cleaned before they reach your site. There are a few things worth doing yourself, especially on a client's site.

## Turn on two-factor sign-in

Two-factor sign-in asks for a code from an app on your phone as well as your password, so a stolen password alone isn't enough.

1. Open **Account**. Under **Security**, press **Set Up** beside **Two-Factor Authentication**.
2. Scan the code with an authenticator app, or copy the **Setup Key** into it, type the code it shows and press **Turn On**.
3. Save the recovery codes somewhere safe. Each works once if you lose your phone.

## See who changed what

The **Audit Log** lists every change: who made it, when, and how, whether in the admin, through the API, from the command line, by the assistant or by an AI agent.

![The audit log: every change, with who made it and how.](/media/screens/audit.webp)

Narrow the log to one person or one action, and open a change to see what was sent.

Entries are kept for a year. On the log's **Settings** tab, **Keep Entries For** keeps them longer or shorter (0 keeps them forever), and **Also Record Reads** records who looked at what, if you must be able to show it.

## Give each person only what they need

Give clients a [role](/operations/users-and-roles) that covers their content and nothing else. Permissions marked **Trusted Only** are for people you trust completely: **Add Custom HTML Blocks** and **Edit Custom CSS and JavaScript**, because both can put scripts on every page, and **Install Unsigned Packages**, because a package can run any code.

## Keep AI and API access in check

- **API tokens** are shown once. Give each one only the access it needs and an expiry date, and you can see when it was last used.
- **AI agents** work through the same permissions as the person who connected them, and you approve each one first.
- An agent or the assistant can never create tokens, change passwords or two-factor settings, create, invite, change or remove people, grant or take away roles, or change what a role may do. People do that themselves, in **Settings**.
- The **assistant** asks before deleting anything or making admin-level changes, and never takes instructions from your site's content or from what visitors wrote. Once a chat has read such content, it asks before anything but saving a draft.

## What Lettern does for you

- Passwords are stored as one-way hashes, and sign-in is limited after a few wrong tries.
- Uploaded files are checked by their contents, scripts are stripped from SVG images, and photo metadata is removed.
- Text people write is cleaned, so it can't add scripts to your pages.
- Forms catch spam bots without a puzzle for your visitors.
- Every response carries the browser's security headers.
- Visitors get published files, so most requests never reach PHP or the database.

## For developers

### Accounts and sessions

- Passwords are hashed with Argon2id. Sign-in is rate limited per account and per address.
- Two-factor authentication works with any authenticator app, with one-time recovery codes. When it's on, it's also required on the agent consent screen.
- Session cookies are HTTP-only and SameSite, and every admin request carries a CSRF token. A site on its own port (`localhost:8003`) uses cookie names of its own, as browsers share cookies across ports.

### API tokens and agents

- Personal access tokens (`cms_…`) are shown once and stored only as a hash, with scopes, an expiry and when they were last used.
- OAuth for agents uses PKCE (S256 only), short-lived access tokens and rotating refresh tokens. You approve every client on a consent screen.
- Abilities that could take over an account or hand out access (creating tokens, changing passwords or two-factor settings, creating, inviting, changing or removing users, granting roles, changing a role's permissions) are never available to agents or the assistant, even when an admin asks.
- The assistant treats site content and visitor-written text as data, never as instructions. Once a chat has read such content, it asks before anything but saving a draft. Chats are private to their owner and encrypted at rest.

### Every action

All changes go through [abilities](/agents/abilities): input is validated against a schema, permissions are checked (including per collection), and the change is written to the audit log with who, through which channel and from where. Secrets in the input are redacted in the log. Agents read it with `audit/list` and `audit/recent`, with the `audit.view` permission.

### Content and uploads

- Rich text is cleaned with an allow-list HTML sanitizer. Raw HTML blocks need `blocks.html`, and the site's custom JavaScript needs `site.code`.
- Interactions run on Alpine's CSP build: expressions can read and change the element's own state but can't reach `window`, `document`, other globals or arbitrary functions, and every script setting is checked when it's saved. Style values that could escape CSS are refused.
- Links and sources that come from data or from an interaction (a bound `href` or `src`) only take `http(s)`, relative, `#`, `?`, `mailto:` and `tel:` addresses. A `javascript:` URL in a field never reaches the page.
- Uploads are identified by their contents, not their names. SVGs are stripped of scripts and event handlers, and photo metadata is removed. `public/` never executes PHP.
- Fetching remote files (media import) refuses private and internal network addresses, re-checks every redirect and limits size.
- Paths are resolved safely everywhere: no `../` escapes.
- Form submissions pass a honeypot, a time trap, rate limits and an origin check. CSV exports neutralize spreadsheet formulas.

### Headers

Every response sets `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, `Cross-Origin-Opener-Policy` and `X-Frame-Options`, plus HSTS over HTTPS. The admin has a strict content security policy with a per-request nonce, and API responses are never cached.

### Hardening switches

| Setting | Effect |
|---|---|
| `CMS_ALLOW_FILE_MODS=false` | No installing, updating or deleting plugin files from the admin. |
| `CMS_INSTALL_TOKEN` | The web installer requires this token. |
| `APP_DEBUG=false` | Never show error details on a live site. |
