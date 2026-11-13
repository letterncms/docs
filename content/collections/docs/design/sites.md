---
id: 01m7ae1ktgdb8dac2b06k6b2bk
title: Sites
position: 11
description: 'A whole site you can switch to and back: choosing one, trying others without losing your work, and making one from your own site.'
---
Open **Design → Sites** to browse, import, export, and switch between complete sites. Each can contain pages, posts, collections, menus, design, and media. When you switch, Lettern saves your work so you can return to it later.

**Minimal** is selected when you install Lettern. It has a home page, an about page, and a blog with three posts. Setup downloads it from the store as `letterncms/minimal`. You can also choose another site or start with an empty one.

An exported site is a portable folder of Markdown, YAML, JSON, and media. You can keep it in version control, share it, or use it as the starting point for another installation.

## Choosing one when you install

Setup shows the sites it can start from under **Start From**, each with its picture and its name. **Minimal** is chosen; pick another, or none for an empty site. Sites from the store appear there too, and setup fetches the one you choose as it fetches a plugin, Minimal included. If it can't, setup says so: try again, or start without a site.

From the command line, `--site` chooses it:

```bash
php cms install --site=studio            # a site in sites/, or one to fetch: letterncms/studio
php cms install --site=none              # an empty site
```

If your installation already has collections, setup uses the existing content.

## Getting more sites

Open **Design → Sites → Browse Store** to find and install a site. Installed sites appear on **Sites**, where you can switch to them. To update a site you got from the store, open its listing in **Browse Store**.

## Switching sites

Choose a site from the name at the top of the sidebar or open **Design → Sites**. The selection takes effect immediately.

Lettern saves the current site, including drafts, before switching. Choose it again to resume where you left off, or use **Undo** immediately after switching. **Start Over** restores a site's original files and asks before deleting its saved changes.

A switch replaces what a site carries (see below) and nothing else. Accounts, the media library, form submissions, analytics, the audit log and every setting a site doesn't carry stay. If the site needs plugins your site doesn't run, **Sites** says which, with a way to the store. A site with scripts or styles needs **Edit Custom CSS and JavaScript**, and a switch needs the permission to edit the settings. A switch that fails leaves the site as it was; a snapshot of the site is also in `storage/backups/`.

```bash
php cms site:list
php cms site:switch studio                 # the site you leave is saved
php cms site:switch studio --fresh          # the site as it came
```

## Applying a site

Apply a site to bring its content or design into the one you're working on.

```bash
php cms site:apply studio --mode=design --dry-run     # every step, nothing written
php cms site:apply studio --clash=rename                # refuse (the default), skip, replace or rename
```

`--mode=design` brings the tokens, fonts, templates, components, scripts, styles and libraries; `full` (the default) its content too. While your site has something of a name the site brings, the apply refuses and names each one, until `--clash` says what happens to it: `skip` (yours stays), `replace` (the site's takes its place, after a snapshot in `storage/backups/`) or `rename` (an entry comes in beside yours under a new address, like `home-2`). Everything a site would write is checked before the first file is, and a site that fails on the way leaves your site as it was.

Entries come in under ids of their own, and whatever named them follows: relations, parents, translations, menu items, links and components on blocks. A date that was ahead of the site's making is as far ahead now; an end date that has passed brings the entry in as a draft.

## Exporting a site

**Export Site** downloads a ZIP of the current site. Use `php cms site:export <folder>` to write the files directly to a folder.

| What | Where in the site |
|---|---|
| Collections and their published entries (drafts with `--drafts`), always in the file layout | `content/collections/` |
| Templates and components | `content/collections/templates/`, `components/` |
| Globals and menus | `content/globals/`, `content/navigation/` |
| The design, fonts, scripts, styles and vendored libraries | `content/design/` |
| The images and files something in it names, with their records | `content/media/`, `public/media/` |
| The few settings a site carries: the site's description, favicon and search index | `config/site.yaml` |
| What a plugin keeps beside the content and says is part of a site (Forms' forms, SEO's redirects) | `content/forms/`, `content/redirects.yaml` |
| What it is | `site.json` |

The sites you leave are kept in `storage/sites/<name>`, in this same layout. What plugins collect while the site runs (form submissions, analytics) is data of the server, not of a site.

A site never holds accounts, tokens, secrets, form submissions, analytics, the audit log, licences, the site's name, address or mail settings, or any collection a plugin keeps for itself.

## Naming a site

A site's name, description and thumbnail come from its `site.json` and `previews/`. **Export Site** asks for them (left empty, the description is your site's own), and **Edit Details** on a site's menu changes them later. Agents use `sites/update`.

## Deleting a site

**Delete** on a site's menu removes the site and the copy kept of it, with what you changed in it; your site stays as it is. Switch away from the active site before deleting it. Minimal can be deleted like any other site, and installed again from **Browse Store** when you want it. Agents use `sites/delete`.

## Importing a site

**Import Site** on the same screen takes the zip that **Export Site** downloaded (or any site's folder, zipped) and keeps it in `sites/`, ready to switch to. Nothing about your site changes until you choose it. A zip is read without trust: a path outside the site, a link or a file a server would run refuses it, and a site whose handle you already have is refused too. Agents use `sites/import`.

## Sites as packages

A site is shared as a Composer package of type `cms-site`: the site's folder with a `composer.json` beside `site.json`. `composer require` puts it in your site's `sites/<name>` (a third party's in `sites/<vendor>-<name>`), and the store installs it there the same way. Composer never empties a `sites/` folder it didn't put there itself.

```json
{
    "name": "acme/studio",
    "type": "cms-site",
    "version": "1.0.0",
    "require": { "letterncms/cms": ">=0.35 <1" }
}
```

`site.json` says what it is: `handle` (its folder's name), `name`, `version`, and optionally `description`, `license`, `cms` (a version constraint), `plugins` (the packages it needs), `languages` (the main one first), `previews` (pictures in `previews/`, the first shown when choosing) and `demo`. A site is read without trust: a file its layout doesn't name, a link, a hidden file, a file a server would run, one that is too large or isn't what it says refuses the whole site, by name, before anything is copied.

## For agents

The same through abilities: `sites/list` (`active` identifies the current site and `edited` identifies saved copies), `sites/switch` (`fresh` for the site as it came; `saved` says what was kept), `sites/get` (with `mode`, the plan step by step), `sites/import` (a site's zip, base64), `sites/apply` (run it with `dryRun` first: `changes` lists every step, and it refuses while there is a clash) and `sites/export`.
