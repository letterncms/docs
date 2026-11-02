---
id: 01m5wmrf5x1dk7bnf2yz3j4zbc
title: Upgrading
position: 5
group: 'Your project'
description: One click in the admin, or `composer update`. A self-updating release goes live by switching a pointer, and goes back the same way if it fails its own checks.
---
A site set up from the zip updates itself: open **Modules**, then **Updates**, and click **Update**. It needs no special server: PHP that can write to its own folder is enough, and each step is a request short enough for any shared host.

A site managed with Composer updates with Composer:

```bash
composer update
php cms sync
php cms build
```

Your site's files (`config/`, `content/`, `plugins/`, `public/media/`, `storage/`, `.env`) are separate from Lettern's code, so an update of Lettern never touches them.

## What happens in the admin

Each release lives in its own folder, `runtime/<version>/`, and the one-line file `runtime/current` names the one in use.

1. **Download and verify.** The zip comes from the signed update list. Its hash and its signature must match, field by field. A failure here stops everything, with nothing changed.
2. **Unpack and check.** The release is unpacked beside the live one, and every file is compared with the release's own list.
3. **Switch.** One rename of `runtime/current`. Requests in flight finish on the old code. Dynamic pages answer 503 with `Retry-After` for the few seconds migrations take; static pages keep serving.
4. **Migrate and check itself.** The new code migrates the database and every package, lifts the gate, then checks the database, every module, the admin and the home page.
5. **Settle, or go back.** Any failure renames the pointer back, and the site runs the old code as before. For 15 minutes after that, three fatal errors in the new release's own code do the same. A plugin's fatal, or a memory limit, doesn't count.

**Go back** on the Updates screen returns to the previous release for as long as it is on disk (7 days). The database stays as it is: within a major, migrations only add.

## Security updates

Security releases install by themselves by default, on any signed-in admin's visit, or from cron with `php cms packages:update --security-only`. A public request never starts or advances an update. A quiet site with neither stays where it is, so add the cron line if nobody signs in for weeks.

They don't go by themselves when a plugin wouldn't suit the new version, when the release needs something the host lacks, while postponed (up to 14 days), or after failing twice. Each of those becomes a banner for people who can act on it. Turn them off under **Updates**, or with `CMS_UPDATE_AUTO=false`.

Checking sends nothing but a User-Agent with the version, at most every 12 hours. `CMS_UPDATE_CHECK=false` turns it off.

## When the host can't do it

If `runtime/` isn't writable, or the host lacks `ZipArchive` or `curl`, **Updates** says so. Download the zip, upload `runtime/<version>/` by FTP, and click **Switch**, or edit `runtime/current` by FTP and run `php cms sync`.

## Sites managed with Composer

A site without `runtime/`, a folder with `.git` and `CMS_ALLOW_FILE_MODS=false` all count as deployed: the screen only tells you a version is out, and you update through your deploy. Run `php cms sync` after the code changes, then `php cms build`.

## What changed

The [changelog](https://lettern.org/changelog) lists every release. Each package also has its own `CHANGELOG.md`, in English.

## Plugins

Every plugin is versioned on its own. On a site that updates itself, those from the store update from **Updates**, only from the store they came from, each with a backup and a **Go Back** for 7 days. Security versions go by themselves when they ask for no new capabilities. A store's advisory about what you run is a warning: Lettern never switches a plugin off for it.

A plugin whose requirements are not met (another plugin, a Lettern version, a PHP library) is switched off with the reason shown in **Modules**, instead of breaking the site.

::: callout {"props":{"tone":"warning","text":"Read the release notes before updating across a major version. Plugins built for an older major version may need an update."}}
:::
