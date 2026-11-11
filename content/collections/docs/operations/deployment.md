---
id: 01m5wnc9y925fbehg4t6ekqgqs
title: Deployment
position: 1
description: Put a site online, from a simple upload to shared hosting to git with staging and production.
---
Lettern runs on ordinary PHP hosting. For a small site, upload it and you're done. For client work with a staging site, keep the design and structure in git and move content with Sync.

## On shared hosting

Upload the zip, open the site in a browser, and setup does the rest. See [Installation](/getting-started/installation). Published pages are served straight from files, so the site stays fast on the smallest plan.

Back up the database and the site folder. Everything else can be downloaded again.

## Local, staging and production

Most agencies build on their own machine, show the client a staging site, and run the real one in production. Two kinds of things travel between them, in two ways:

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"Design, structure and settings travel from your machine to staging and production with git. Content and media travel between any two of them with Sync.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Your machine</b><span class=\"docs-card__field\">Templates</span><span class=\"docs-card__field\">Collections</span><span class=\"docs-card__field\">Settings</span></div><b>Git</b><small>Design and structure</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Staging</b><span class=\"docs-card__field\">Pages</span><span class=\"docs-card__field\">Media</span></div><b>Sync</b><small>Content, both ways</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Production</b><span class=\"docs-card__field\">Pages</span><span class=\"docs-card__field\">Orders</span><span class=\"docs-card__field\">Accounts</span></div><b>The live site</b><small>What visitors leave stays here</small></div></div></figure>"}}
:::

- **Design and structure** (templates, components, collections, settings) are plain files in `content/` and `config/`, so they go through git like code.
- **Content** written in the admin (pages, posts, media) lives in the database. Move it between your machine, staging and production with [Sync](/operations/sync), in either direction.

::: callout {"props":{"tone":"tip","text":"Keep search engines off your staging site: turn on <strong>Discourage All Indexing</strong> under <strong>Settings → SEO</strong>."}}
:::

## For developers

### Deploy with git

1. Commit `composer.json`, `composer.lock`, `config/` and `content/`, and the plugins you wrote yourself.
2. On the server, after pulling, run:

```bash
composer install --no-dev --optimize-autoloader
php cms migrate
php cms build
```

`php cms migrate` brings the database up to the code. Run it on every deploy, whether or not you think something changed:

- It runs the migrations of Lettern and of every active plugin, and each plugin's install and upgrade steps.
- It imports `content/media`, and writes `public/media/.htaccess` if it is missing or out of date.
- It never asks before it runs. `--force` is accepted, for deploy scripts that pass it.
- It takes what the framework's command of that name takes: `--database`, `--step`, and `--path` with `--realpath` to run only the migrations named. `migrate:status`, `migrate:rollback`, `migrate:fresh`, `migrate:refresh`, `migrate:reset` and `migrate:install` work on the core's tables and the plugins'.

Add `--json` to any of the three for one JSON document and a non-zero exit when it failed, which a deploy script can test: see [Command line](/agents/cli#json-from-every-command).

A deploy that updates packages runs `composer update` instead of `composer install`. Update the CMS and its plugins together: Composer refuses to install a CMS release beside a plugin release that still calls names that release removed.

::: callout {"props":{"tone":"warning","text":"<code>cms migrate</code> was <code>cms sync</code> before version 0.22, and <code>cms update</code> was <code>cms packages:update</code>. The old names are gone, so a deploy script that still calls them fails. See <a href=\"/getting-started/upgrading#names-that-changed-in-022\">Upgrading</a>."}}
:::

3. What people change in the admin on the server, like settings or a collection, is saved to `config/` and `content/` there. Commit it from the server, or make the same change locally and deploy it, so the next deploy finds no difference.

Store entries that should be versioned, like documentation or landing pages, in collections with `driver: files`. Entries in the database (posts written by editors, form submissions) stay on the server, and [Sync](/operations/sync) moves them.

### Environments

Each environment has its own `.env`: the database, the app key, secrets, and debug off in production. Any setting can be overridden per environment with a `CMS_<NAMESPACE>_<KEY>` variable, so production credentials never enter git.

### Static hosting and CDNs

After `php cms build`, `public/` is a complete static site. Sync it to a CDN or object storage and keep the admin on a private host. Forms and other live features keep posting to the Lettern server's APIs. See [Publishing](/operations/publishing).

### Servers behind a proxy

Lettern fetches a few things itself: updates, the plugin store, remote media, Google Fonts, libraries for `cms vendor`, Sync and webhooks. It connects to them directly and never uses a proxy from the server's environment (`http_proxy`, `https_proxy`, `ALL_PROXY`), because a proxy would connect to an address nobody checked. A server that can only reach the internet through a proxy can't fetch these: update it through your deploy, with Composer, which does use the proxy.

### Scheduled tasks

Nothing needs cron: builds and scheduled publishing run after requests. If you do have cron, run `php cms publish:scheduled` every minute for exact timing. With the [Webhooks](/operations/webhooks#without-a-worker) plugin on a server that is neither PHP-FPM nor LiteSpeed, add `php cms webhooks:deliver`, and for [security updates](/getting-started/upgrading#security-updates-from-cron) on a site nobody signs in to, `php cms update --security-only`.
