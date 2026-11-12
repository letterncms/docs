---
id: 01m7ae1ktgdb8dac2b06k6b2bk
title: Site kits
position: 11
description: 'A whole site you can switch to and back: choosing one, trying others without losing your work, and making one from your own site.'
---
A site kit is a complete site: its pages and posts, its collections, menus and global sets, its design system, templates and components, its scripts, styles and fonts, and the images they show. Your site is one kit at a time, and you can switch between kits and back. Once a kit is on your site every file is yours: nothing links back to it, and a newer version of the kit never changes a site that started from an older one.

A new site starts from **Minimal**, which comes with Lettern: a home page, an about page and a blog with three posts.

A kit is the portable form of a site. It is a folder of Markdown, YAML and JSON (plus the images), whatever your collections store their entries in, so you can keep it in a repository of its own, hand it to someone, or run several sites from kits you made.

## Choosing one when you install

Setup shows the kits it can start from under **Start From**, each with its picture and its name. **Minimal** is chosen; pick another, or none for an empty site. Kits from the store appear there too, and setup fetches the one you choose as it fetches a plugin. If it can't, setup says so: try again, or start from Minimal.

From the command line, `--kit` chooses it:

```bash
php cms install --kit=fathomline        # a kit in kits/, or one to fetch: letterncms/fathomline
php cms install --kit=none              # an empty site
```

A site that already has collections (one you cloned with its content) is never given a kit.

## Switching kits

Choose a kit from the site's name at the top of the sidebar, or under **Design → Site Kits**. The site is that kit at once: no settings, nothing to decide.

What your site was is saved first, drafts included, with the kit it was. Switch back and you get it as you left it, not as the kit came. The toast after a switch has **Undo**, which does the same. A kit's menu on **Site Kits** has **Start Over**, which brings the kit as it came and lets go of what you changed (it asks first), and **Use Only the Design**, which replaces the templates, components, fonts and styles and leaves your pages, posts and menus.

A switch replaces what a kit carries (see below) and nothing else. Accounts, the media library, form submissions, analytics, the audit log and every setting a kit doesn't carry stay. If the kit needs plugins your site doesn't run, **Site Kits** says which, with a way to the store. A kit with scripts or styles needs **Edit Custom CSS and JavaScript**, and a switch needs the permission to edit the settings. A switch that fails leaves the site as it was; a snapshot of the site is also in `storage/backups/`.

```bash
php cms kit:list
php cms kit:switch fathomline              # the site you leave is saved
php cms kit:switch minimal --fresh         # the kit as it came
```

## Putting a kit on top

To bring a kit's parts in beside what your site has, instead of replacing it, apply it:

```bash
php cms kit:apply fathomline --mode=design --dry-run     # every step, nothing written
php cms kit:apply fathomline --clash=rename              # refuse (the default), skip, replace or rename
```

`--mode=design` brings the tokens, fonts, templates, components, scripts, styles and libraries; `full` (the default) its content too. While your site has something of a name the kit brings, the apply refuses and names each one, until `--clash` says what happens to it: `skip` (yours stays), `replace` (the kit's takes its place, after a snapshot in `storage/backups/`) or `rename` (an entry comes in beside yours under a new address, like `home-2`). Everything a kit would write is checked before the first file is, and a kit that fails on the way leaves your site as it was.

Entries come in under ids of their own, and whatever named them follows: relations, parents, translations, menu items, links and components on blocks. A date that was ahead of the kit's making is as far ahead now; an end date that has passed brings the entry in as a draft.

## Making a kit from your site

**Export Site** on the same screen makes your site into a kit in `kits/<name>`, and `php cms kit:export <folder>` writes one anywhere. A kit holds:

| What | Where in the kit |
|---|---|
| Collections and their published entries (drafts with `--drafts`), always in the file layout | `content/collections/` |
| Templates and components | `content/collections/templates/`, `components/` |
| Global sets and menus | `content/globals/`, `content/navigation/` |
| The design system, fonts, scripts, styles and vendored libraries | `content/design/` |
| The images and files something in it names, with their records | `content/media/`, `public/media/` |
| The few settings a kit carries: the site's description, favicon and search index | `config/site.yaml` |
| What a plugin keeps beside the content and says is part of a site (Forms' forms, SEO's redirects) | `content/forms/`, `content/redirects.yaml` |
| What it is | `kit.json` |

The kits you leave are kept in `storage/kits/<name>`, in this same layout. What plugins collect while the site runs (form submissions, analytics) is data of the server, not of a kit.

A kit never holds accounts, tokens, secrets, form submissions, analytics, the audit log, licences, the site's name, address or mail settings, or any collection a plugin keeps for itself.

## Importing a kit

**Import Site** on the same screen takes the zip that **Export Site** downloaded (or any kit's folder, zipped) and keeps it in `kits/`, ready to switch to. Nothing about your site changes until you choose it. A zip is read without trust: a path outside the kit, a link or a file a server would run refuses it, and a kit whose handle you already have is refused too. Agents use `kits/import`.

## Kits as packages

A kit is shared as a Composer package of type `cms-kit`: the kit's folder with a `composer.json` beside `kit.json`. `composer require` puts it in your site's `kits/<name>` (a third party's in `kits/<vendor>-<name>`), and the store installs it there the same way. Composer never empties a `kits/` folder it didn't put there itself.

```json
{
    "name": "acme/studio",
    "type": "cms-kit",
    "version": "1.0.0",
    "require": { "letterncms/cms": ">=0.25 <1" }
}
```

`kit.json` says what it is: `handle` (its folder's name), `name`, `version`, and optionally `description`, `license`, `cms` (a version constraint), `plugins` (the packages it needs), `languages` (the main one first), `previews` (pictures in `previews/`, the first shown when choosing) and `demo`. A kit is read without trust: a file its layout doesn't name, a link, a hidden file, a file a server would run, one that is too large or isn't what it says refuses the whole kit, by name, before anything is copied.

## For agents

The same through abilities: `kits/list` (`active` says which kit the site is, `edited` which have a saved copy), `kits/switch` (`fresh` for the kit as it came; `saved` says what was kept), `kits/get` (with `mode`, the plan step by step), `kits/import` (a kit's zip, base64), `kits/apply` (run it with `dryRun` first: `changes` lists every step, and it refuses while there is a clash) and `kits/export`.
