---
id: 01m7ae1ktgdb8dac2b06k6b2bk
title: Site kits
position: 11
description: 'A whole site to start from, copied in once: choosing one, applying one later, and making one from your own site.'
---
A site kit is a complete site to start from: its pages and posts, its collections, menus and global sets, its design system, templates and components, its scripts, styles and fonts, and the images they show. It is copied into your site once. From then on every file is yours: nothing links back to the kit, and a newer version of the kit never changes a site that started from an older one.

A new site starts from **Minimal**, which comes with Lettern: a home page, an about page and a blog with three posts.

## Choosing one when you install

Setup shows the kits it can start from under **Start From**, each with its picture and its name. **Minimal** is chosen; pick another, or none for an empty site. Kits from the store appear there too, and setup fetches the one you choose as it fetches a plugin. If it can't, setup says so: try again, or start from Minimal.

From the command line, `--kit` chooses it:

```bash
php cms install --kit=fathomline        # a kit in kits/, or one to fetch: letterncms/fathomline
php cms install --kit=none              # an empty site
```

A site that already has collections (one you cloned with its content) is never given a kit.

## Applying a kit later

Open **Design → Site Kits** and choose a kit. Before anything happens you see what it would do here:

- **Bring In**: **Design and Content** brings everything; **Design Only** brings the tokens, fonts, templates, components, scripts, styles and libraries, and leaves your content alone.
- The counts: what is new, what replaces, what comes in under a new name, and what is left as it is because your site has the same.
- **Already on This Site**: what your site already has under a name the kit brings, by name. Nothing is applied until you choose: **Keep the Site's** (the kit's is left out), **Replace** (the kit's takes its place, after a snapshot in `storage/backups/`) or **Keep Both** (an entry comes in beside yours under a new address, like `home-2`).
- The plugins it needs that your site doesn't run: add them from the store, or tick **Apply Without Them**, knowing what of the kit needs them may not show.

Applying needs the permission to edit the settings, and to do what the kit does: create collections, entries, menus, global sets, media and languages. A kit with scripts or styles also needs **Edit Custom CSS and JavaScript**. Everything a kit would write is checked before the first file is, and a kit that fails on the way leaves your site as it was.

```bash
php cms kit:list
php cms kit:apply fathomline --mode=design --dry-run     # every step, nothing written
php cms kit:apply fathomline --clash=rename              # refuse (the default), skip, replace or rename
```

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
| What it is | `kit.json` |

A kit never holds accounts, tokens, secrets, form submissions, analytics, the audit log, licences, the site's name, address or mail settings, or any collection a plugin keeps for itself.

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

The same through abilities: `kits/list`, `kits/get` (with `mode`, the plan step by step), `kits/apply` (run it with `dryRun` first: `changes` lists every step, and it refuses while there is a clash) and `kits/export`.
