---
id: 01m5wmrf5x1dk7bnf2yz3j4zbc
title: Upgrading
position: 3
description: Update Lettern with one click, and if anything goes wrong, it goes back by itself.
---
Keeping Lettern up to date takes one click in the admin. Each update checks itself once it's live, and if anything fails, your site goes straight back to the version it had.

Your content, settings, plugins and media are kept apart from Lettern's own code, so an update never touches them.

::: tabs {"props":{"label":"Ways to update"}}
:::: tab-panel {"props":{"label":"From the admin"}}
For sites installed from the zip.

1. Open **Modules** and the **Updates** tab. Press **Check Now** if you don't want to wait for the next check.
2. Next to the new version, press **Update**.
3. Wait a few seconds while it downloads, checks and switches. A message tells you when it's done.

Any PHP hosting that lets Lettern write to its own folder can do this. Each step is a short request, so it works on shared hosting too.
::::

:::: tab-panel {"props":{"label":"With Composer"}}
For sites managed with Composer, in your site's folder:

```bash
composer update
php cms sync
php cms build
```

`php cms sync` runs the database migrations of Lettern and every plugin, and `php cms build` builds the pages again.
::::
:::

## What happens when you update

The new version is downloaded and checked beside your live site, so nothing changes until it's ready. Then the site switches over in an instant, and the new version checks itself.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"The new version is downloaded and checked beside the live one, the site switches over in one step, and the new version checks itself. If a check fails, the site switches back.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Current version</span><em>live</em></div><div class=\"docs-card docs-card--row\"><span>New version</span><em>checked</em></div></div><b>Download and check</b><small>Beside the live site</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Current version</span><em>kept</em></div><div class=\"docs-card docs-card--row\"><span>New version</span><em>live</em></div></div><b>Switch</b><small>One step, in an instant</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Database</span><em>✓</em></div><div class=\"docs-card docs-card--row\"><span>Admin, home page</span><em>✓</em></div></div><b>Check itself</b><small>Any failure switches back</small></div></div></figure>"}}
:::

If a check fails, the site goes back to the version it had, and the **Updates** screen tells you what happened. Your content is safe either way.

## Go back

Changed your mind? For 7 days after an update, the **Updates** screen shows **Go back**, which returns to the previous version. Your content stays as it is.

::: callout {"props":{"tone":"warning","text":"A new major version (2.0 after 1.x) can change more. Lettern asks you to confirm first, and lists any plugins that won't work with it. Back up and read the release notes before you go ahead."}}
:::

## Security updates

Security updates install by themselves, the next time anyone uses the admin. You'll see a banner when one couldn't, with the reason.

To decide for yourself, turn off **Install security updates by themselves** on the **Updates** screen. **Postpone 7 Days** holds one back for a while.

## Plugins

Each plugin has its own versions. Plugins from the store update from the same **Updates** screen, each with its own **Update** button and a **Go Back** for 7 days. Their security updates install by themselves too, as long as they ask for no new capabilities.

If a store warns about a plugin you run, you'll see it under **Security advisories**. Lettern never switches a plugin off for it: you decide.

If a plugin needs something your site doesn't have, like another plugin or a newer Lettern, it's switched off with the reason shown in **Modules**, instead of breaking the site.

## What changed

Each release on the **Updates** screen links to **What changed**. The [changelog](https://lettern.org/changelog) lists every release, and each package also has its own `CHANGELOG.md`, in English.

## For developers

### How a self-update works

Each release lives in its own folder, `runtime/<version>/`, and the one-line file `runtime/current` names the one in use.

1. **Download and verify.** The zip comes from the signed update list. Its hash and its signature must match, field by field. A failure here stops everything, with nothing changed.
2. **Unpack and check.** The release is unpacked beside the live one, and every file is compared with the release's own list.
3. **Switch.** One rename of `runtime/current`. Requests in flight finish on the old code. Dynamic pages answer 503 with `Retry-After` for the few seconds migrations take; static pages keep serving.
4. **Migrate and check itself.** The new code migrates the database and every package, lifts the gate, then checks the database, every module, the admin and the home page.
5. **Settle, or go back.** Any failure renames the pointer back, and the site runs the old code as before. For 15 minutes after that, three fatal errors in the new release's own code do the same. A plugin's fatal, or a memory limit, doesn't count.

**Go back** works while the previous release is on disk (7 days). The database stays as it is: within a major version, migrations only add.

### Security updates from cron

Automatic security updates advance on any signed-in person's visit to the admin, or from cron with `php cms packages:update --security-only`. A public request never starts or advances an update, so a site nobody signs in to for weeks stays where it is: add the cron line.

They don't go by themselves when a plugin wouldn't suit the new version, when the release needs something the host lacks, while postponed (up to 14 days), or after failing twice. `CMS_UPDATE_AUTO=false` turns them off.

Checking for updates sends nothing but a User-Agent with the version, at most every 12 hours. `CMS_UPDATE_CHECK=false` turns it off.

### When the host can't update itself

If `runtime/` isn't writable, or the host lacks `ZipArchive` or `curl`, **Updates** says so. Download the release, upload it to `runtime/<version>/` by FTP, then switch to it with the `packages/update-switch` ability, over the [REST API](/agents/rest-api) or with `php cms run packages/update-switch version=<version>`. Or edit `runtime/current` by FTP and run `php cms sync`.

### Sites updated by your deploy

A site without `runtime/current`, a folder with `.git`, or `CMS_ALLOW_FILE_MODS=false` all count as deployed: **Updates** only tells you a version is out, and you update through your deploy. Run `php cms sync` after the code changes, then `php cms build`.
