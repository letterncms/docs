---
id: 01m5wmrf63bvtb0eb632spwma8
title: Project structure
position: 0
description: 'What is in a site''s folder, where Lettern''s own code lives, and what belongs in git.'
---
A Lettern site is one folder: your configuration, content and plugins, with Lettern's own code beside them. Updates replace the code and never touch your content.

However the site was installed, from the zip or with Composer, the folder is a Composer project: `composer.json` lists what it uses.

## The folder

| Path | What it holds | Commit to git? |
|---|---|---|
| `index.php`, `cms`, `.htaccess` | Front controller, command line and Apache rules. Lettern keeps them current. | With Composer: no. They come back on `composer install` |
| `setup.php`, `bundle.json` | What a fresh upload uses to fetch the release. Unused once it has run. | No |
| `composer.json`, `composer.lock` | What this site uses: `letterncms/cms` and its plugins. | Yes |
| `vendor/` | Lettern and the libraries it runs on, on a site managed with Composer. | No |
| `runtime/` | The same `vendor/`, one folder per release, on a site that updates itself. | No |
| `plugins/` | The plugins of this site: `plugins/<name>`, and a third party's in `plugins/<vendor>-<name>`. Your own go here too. | Only what you wrote |
| `config/` | `site.yaml` (name, URL, languages, the admin's language), `plugins.yaml` (enabled plugins, disabled modules), `roles.yaml`, `admin.yaml` (the default sidebar and Dashboard) and one YAML file per settings namespace. | Yes |
| `config/license.key` | The [key of a paid plugin](/reference/license#paid-plugins), when this site has one. | Yes |
| `content/design/` | The design system (`tokens.json`), fonts, `custom.css` and `custom.js`. | Yes |
| `content/collections/` | Collection definitions, and entries of file-based collections, including `templates/` and `components/`. | Yes |
| `content/` (the rest) | Fieldsets, globals, forms, menus, redirects. | Yes |
| `public/` | What visitors get: built pages, uploaded media in `media/`, and in `_cms/` generated images, compiled CSS, fonts and plugin assets. | Media only |
| `storage/` | Logs, caches, drafts of file-based entries (unpublished template and component changes too), encrypted secrets, the SQLite database. | No |
| `.env` | Database credentials, app key, environment flags. | No |

## Where the code is

Lettern itself is the Composer package `letterncms/cms`, at `vendor/letterncms/cms`. You don't edit it, and an update replaces it. It holds:

| Folder | What it holds |
|---|---|
| `src/` | The kernel: content, users, abilities, the package system, HTTP and CLI. |
| `modules/` | The admin's [modules](/plugins/modules): the admin itself, content, collections, globals, users, account, audit, the Dashboard, settings, the Plugins screen, paid plugins' licenses, the assistant and Sync. |
| `brand/` | `brand.json` (the product's name and links), `wordmark.svg` and `mark.svg`; see [Configuration](/reference/configuration). |

A site that updates itself keeps that `vendor/` in `runtime/<version>/vendor/`, and the one-line file `runtime/current` names the release in use. That is how [an update](/getting-started/upgrading) goes live and goes back. On a site managed with Composer there is no `runtime/`, and `vendor/` sits in the site folder.

## What to put in git

Commit `composer.json`, `composer.lock`, `config/`, `content/` and the plugins you wrote. The design system, templates, components, collections, global sets, menus, forms and file-based entries are plain JSON, YAML and Markdown that diff nicely. Ignore `vendor/`, `runtime/`, `storage/`, `.env`, the plugins Composer installs and the generated parts of `public/`. New projects come with a `.gitignore` that does this.
