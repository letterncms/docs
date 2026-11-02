---
id: 01m5wnc9y925fbehg4t6ekqgqs
title: Deployment
position: 0
description: From shared hosting to a git-based workflow with separate environments.
---
## Shared hosting

Upload the zip, open the site in a browser, done. The included `.htaccess` serves built pages straight from `public/`, so the site stays fast on the smallest plan. Back up the database and the site folder; everything else can be downloaded again.

## Git-based workflow

Because configuration and structure are files, you can develop locally and deploy with git:

1. Commit `composer.json`, `composer.lock`, `config/` and `content/`, and the plugins you wrote yourself.
2. On the server, after pulling, run:

```bash
composer install --no-dev --optimize-autoloader
php cms sync
php cms build
```

3. What people change in the admin on the server, like settings or a collection, is saved to `config/` and `content/` there. Commit it from the server, or make the same change locally and deploy it, so the next deploy finds no difference.

Store entries that should be versioned — documentation, landing pages — in collections with `driver: files`. Entries in the database (posts written by editors, form submissions) stay on the server. To move them and the media between your machine, staging and production, use [Sync](/operations/sync).

## Environments

Each environment has its own `.env` (database, app key, debug off in production, secrets). Settings can be overridden per environment with `CMS_<NAMESPACE>_<KEY>` variables, so production credentials never enter git.

## Static hosting and CDNs

After `cms build`, `public/` is a complete static site. Sync it to a CDN or object storage and keep the admin on a private host; forms and other dynamic features keep posting to the Lettern server's APIs.

## Scheduled tasks

Nothing needs cron: builds and scheduled publishing run after requests. If you do have cron, run `php cms publish:scheduled` every minute for exact timing.
