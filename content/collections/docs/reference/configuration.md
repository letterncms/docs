---
id: 01m5wmrf5tccz43yt9s7nj457y
title: Configuration
position: 1
description: Where each setting lives, from secrets in .env to YAML in git and what people change in the admin.
---
Lettern keeps configuration in three places. Pick the one that matches who changes a value and where it should live:

| Where | For | Who changes it |
|---|---|---|
| `.env` | Secrets and what differs per server | Whoever runs the server |
| YAML in `config/` | What describes the site, kept in git | Developers, and the admin when it saves settings |
| **Settings** in the admin | What people change day to day | Anyone allowed to manage settings |

## Environment (`.env`)

Values for this server, and secrets. Never commit this file.

| Variable | Purpose |
|---|---|
| `APP_KEY` | Encryption key, created by the installer. Losing it makes stored secrets unreadable. |
| `APP_ENV`, `APP_DEBUG` | `production` and `false` on live sites. |
| `APP_URL` | The public URL. When a `site.yaml` with another URL came with the site (from git, say), the installer leaves that file alone and sets `CMS_SITE_URL` here too. |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_PREFIX` | The database. |
| `CMS_INSTALL_TOKEN` | Required by the web installer when set. |
| `CMS_ALLOW_FILE_MODS` | `false` stops installing, updating or deleting plugin files from the admin. |
| `CMS_<NAMESPACE>_<KEY>` | Overrides any setting, e.g. `CMS_SITE_URL`, `CMS_MAIL_SMTP_PASSWORD` or `CMS_ASSISTANT_API_KEY`. |

## YAML in `config/`

Values that describe the site and belong in version control.

```yaml
# config/site.yaml
name: Acme
url: 'https://acme.com'
timezone: Europe/Amsterdam
locale: en
locales: [en, de]
```

```yaml
# config/plugins.yaml — which plugins run (every plugin in plugins/ when the file is missing)
# and which of the admin's optional modules don't (see Plugins → Modules)
enabled:
  - letterncms/blocks
  - letterncms/site
  - letterncms/seo
disabled:
  - letterncms/audit
```

```yaml
# config/admin.yaml — the language, and the sidebar and home screen everyone starts with
language: en
```

## Settings

Everything people change in **Settings** belongs to a settings namespace:

- the site itself: name, URL, timezone, language and favicon, in `config/site.yaml`
- the admin: its language and the default sidebar and home screen, in `config/admin.yaml`
- each module: entries per page, audit retention
- each plugin: email transport, SEO defaults, the assistant's model

Each is saved to `config/<namespace>.yaml`, except fields marked secret (passwords, API keys). Those are encrypted into `storage/secrets.json`, never written to YAML, and never shown again in the admin.

Settings are abilities too: `settings/list`, `settings/get` and `settings/update`. See [Settings](/plugins/settings) to add your own.

## The product's name

`brand/brand.json` in `letterncms/cms` holds the name, domain, website, documentation and GitHub URLs and support address that the admin, emails, the installer, the command line and the MCP server show, next to `wordmark.svg` and `mark.svg`. Replacing these three files renames the product in all of those, and the next publish or `cms build` rebuilds every static page; identifiers like `Cms\`, `letterncms/*` and `CMS_*` never change. In PHP, read it with `cms_brand('docs_url')`. In dictionaries, write `:brand` in strings for `__()` and `{brand}` in labels the admin translates. Content is yours: a site's pages name the product in plain text.
