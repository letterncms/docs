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

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"Design, structure and settings travel from your machine to staging and production with git. Content and media travel between any two of them with Sync.\"><div class=\"cluster\" data-gap=\"sm\"><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Your machine</b><span class=\"badge\">Templates</span><span class=\"badge\">Collections</span><span class=\"badge\">Settings</span></div><b class=\"text-label\">Git</b><figcaption>Design and structure</figcaption></figure><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Staging</b><span class=\"badge\">Pages</span><span class=\"badge\">Media</span></div><b class=\"text-label\">Sync</b><figcaption>Content, both ways</figcaption></figure></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Production</b><span class=\"badge\">Pages</span><span class=\"badge\">Orders</span><span class=\"badge\">Accounts</span></div><b class=\"text-label\">The live site</b><figcaption>What visitors leave stays here</figcaption></figure></div></div></figure>"}}
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
php cms sync
php cms build
```

3. What people change in the admin on the server, like settings or a collection, is saved to `config/` and `content/` there. Commit it from the server, or make the same change locally and deploy it, so the next deploy finds no difference.

Store entries that should be versioned, like documentation or landing pages, in collections with `driver: files`. Entries in the database (posts written by editors, form submissions) stay on the server, and [Sync](/operations/sync) moves them.

### Environments

Each environment has its own `.env`: the database, the app key, secrets, and debug off in production. Any setting can be overridden per environment with a `CMS_<NAMESPACE>_<KEY>` variable, so production credentials never enter git.

### Static hosting and CDNs

After `php cms build`, `public/` is a complete static site. Sync it to a CDN or object storage and keep the admin on a private host. Forms and other live features keep posting to the Lettern server's APIs. See [Publishing](/operations/publishing).

### Scheduled tasks

Nothing needs cron: builds and scheduled publishing run after requests. If you do have cron, run `php cms publish:scheduled` every minute for exact timing.
