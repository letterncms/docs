---
id: 01m5wmrf5tccz43yt9s7nj457y
title: Configuration
position: 4
group: 'Your project'
description: Environment variables for secrets and server behavior, YAML for everything you want in git, and settings for what editors change.
---
Lettern has three layers of configuration. Use the one that matches who changes the value and where it should live.

## Environment (`.env`)

Server-specific values and secrets. Never commit this file.

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

Everything people change in **Settings** is a settings namespace — the site itself (name, URL, timezone, language, favicon → `config/site.yaml`), the admin (its language and the default sidebar and home screen → `config/admin.yaml`), each module's (entries per page, audit retention) and each plugin's (email transport, SEO defaults, the assistant's model). Each is saved to `config/<namespace>.yaml`, except fields marked secret (passwords, API keys), which are encrypted into `storage/secrets.json` and never written to YAML or shown again in the admin.

Settings are abilities too: `settings/list`, `settings/get` and `settings/update`. See [Settings](/plugins/settings) to add your own.

## The product's name

`brand/brand.json` in `letterncms/cms` holds the name, domain, website, documentation and GitHub URLs and support address that the admin, emails, the installer, the command line and the MCP server show, next to `wordmark.svg` and `mark.svg`. Replacing these three files renames the product in all of those, and the next publish or `cms build` rebuilds every static page; identifiers like `Cms\`, `letterncms/*` and `CMS_*` never change. In PHP, read it with `cms_brand('docs_url')`. In dictionaries, write `:brand` in strings for `__()` and `{brand}` in labels the admin translates. Content is yours: a site's pages name the product in plain text.
