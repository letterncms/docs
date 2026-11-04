---
id: 01m5ykcdmdzm1ban690v4rpzsq
title: Modules
position: 4
description: The admin itself is a set of modules, built exactly like plugins. Switch off what a site doesn't need.
---
Lettern has no separate "core admin". Every screen you use, from the content lists and the entry editor to users, settings and the Dashboard, comes from a **module**: a package inside `letterncms/cms`, built exactly like a [plugin](/plugins/how-plugins-work).

A module registers its abilities, permissions, settings, sidebar items and screens through the same public API you use, and nothing else knows it by name. So you can switch off the ones a site doesn't need, and read any of them to learn how to build your own.

## The modules

| Module | What it adds | Can be off |
|---|---|---|
| `letterncms/admin` | The admin itself: its frame (sidebar, command palette, sign-in), design tokens and the primitives in `@letterncms/ui` | No |
| `letterncms/content` | Entry lists and the entry editor, drafts, publishing, history, search; one sidebar item per collection | No |
| `letterncms/account` | Each person's **Account** (profile and language, password, two-factor sign-in, API tokens) and, once a site turns them on, visitor accounts on the site | No |
| `letterncms/settings` | The settings pages (one per namespace in the settings sidebar, or a Settings tab on a plugin's own screen) and the `settings/*` abilities | No |
| `letterncms/packages` | The **Plugins** screen (Installed, Store, Updates), updates and the `packages/*` abilities | No |
| `letterncms/license` | Checks the keys of paid plugins, and adds the **Licenses** tab of **Plugins** and the `license/*` abilities once one is on. It never touches the public site. `letterncms/packages` needs it | No |
| `letterncms/workspace` | The [workspace](/getting-started/workspace): threads at the right edge of the admin, for commands, search and an agent when there is one | No |
| `letterncms/media` | The [media library](/content/media): uploads, folders, alt text, focal points and responsive images | No |
| `letterncms/navigation` | [Menus](/content/navigation), edited with drag and drop and kept in sync when pages move | No |
| `letterncms/email` | [Email](/operations/email) for Lettern and its plugins: SMTP, sendmail or log, provider plugins, branded templates and a delivery log | No |
| `letterncms/dashboard` | The **Dashboard**: a greeting and the widgets each person arranges | Yes: the admin opens on the first pinned sidebar item |
| `letterncms/collections` | The **Collections** screen: creating collections and editing their fields | Yes: collections stay as `content/collections/*.yaml` |
| `letterncms/globals` | Global sets, their fields and `/api/v1/globals/<handle>` | Yes |
| `letterncms/users` | **Users** (Team, Visitors, Sign-Up, Profile Fields), invitations and **Roles** | Yes: accounts and `config/roles.yaml` keep working |
| `letterncms/audit` | The **Audit Log**: who changed what, when, from where | Yes: nothing is written |
| `letterncms/blocks` | The block editor, components, templates, styles, data bindings and Block Markdown | Yes, while nothing that builds on it is on (Site, Forms and Commerce do) |
| `letterncms/site` | The [design system](/design/design-system), [templates](/design/templates), rendering, previews, [publishing](/operations/publishing) the static site, search and the starter kit | Yes, for a headless site, while no plugin that builds on it is on (Commerce does) |
| `letterncms/languages` | [Languages](/content/languages): translations linked to their original, localized URLs, hreflang and the language switcher | Yes |
| `letterncms/collaboration` | [Collaboration](/editing/collaboration): who else is on a page, comments with @mentions, and the inbox | Yes |
| `letterncms/mcp` | The [MCP server](/agents/mcp): every ability as a tool for AI clients, signed in with OAuth | Yes |

The required modules are what Lettern needs to keep working: without them there is no admin, and nobody could edit content, secure their account, change a setting or switch a module back on. Everything else is yours to remove. A site with only the required modules and no plugins is a complete, very small CMS.

## Switch a module off

Modules are part of Lettern, not plugins: the ones that can be off are under **Plugins → Built In**, each with its switch. Or switch one off with `php cms plugin disable letterncms/audit`, the `packages/disable` ability (and back on with `packages/enable`), or in `config/plugins.yaml`:

```yaml
enabled:          # plugins that run
  - letterncms/forms
  - letterncms/seo
disabled:         # modules that don't
  - letterncms/audit
  - letterncms/collaboration
```

Modules are on unless they're listed under `disabled`; plugins are on when they're listed under `enabled`.

A module others need can't be switched off before them: `letterncms/collections` needs `letterncms/content`, and `letterncms/blocks` stays on while Site, or a plugin that builds on it, is on. Data is kept, so when you switch a module back on, its items return to the places admins gave them.

## Configure a module

A module's options are a [settings](/plugins/settings) namespace like any plugin's, listed in the settings sidebar:

| Module | Settings |
|---|---|
| `letterncms/audit` | **Keep Entries For** (days; 0 keeps them forever) and **Also Record Reads**, on the Audit Log's **Settings** tab |
| `letterncms/users` | **Roles** and their permissions, under **People** |
| `letterncms/account` | Visitor accounts, on the **Sign-Up** tab of **Users** |
| `letterncms/dashboard` | None of its own: the default Dashboard for everyone is saved with **Customize → Save as Default** on the Dashboard |
| `letterncms/email` | How email is sent, under **Email** (`config/email.yaml`) |
| `letterncms/media` | Upload size, image quality, AVIF and photo metadata, on the **Settings** tab of **Media** |
| `letterncms/languages` | The site's languages and their URLs, under **Languages** (`config/languages.yaml`) |
| `letterncms/site` | The favicon and **Publishing** (static site, rebuilding on publish, search index), under **General** (`config/site.yaml`); the look itself in the **Design System** |

The content module has no settings. Entries per page (50), the autosave delay (1.2 seconds) and the revisions kept per entry (100) are fixed; a plugin can change the revisions kept with the `revisions.keep` [filter](/plugins/hooks).

Values a screen needs reach every admin user through the manifest, under `config.<namespace>` (`useConfig('license')` in `@letterncms/sdk`); the settings themselves stay behind `settings.manage`.

## Who registered what

While a package registers and boots, it's the current scope, so the abilities and settings it adds record it as their owner (`package` in `abilities/list` and `settings/list`). That's how a plugin's row in **Plugins** knows which settings to open.

## Build one

A module is a plugin that ships with Lettern: the same `composer.json` (`type: cms-plugin`), the same provider (`extends Cms\Packages\Plugin`), the same admin module. Only three things differ:

- It lives in `modules/` of `letterncms/cms`.
- `"required": true` in `extra.cms` marks the ones that may not be switched off.
- It doesn't have to bring a Dashboard widget, as every plugin must. Most do anyway.

If you know how to write a plugin, you know how to write a module. Read `modules/audit` (a provider, one ability, one screen, one setting) next to [Your first plugin](/plugins/your-first-plugin).

The `admin` module provides almost no screens of its own: it's what the others draw in. It only talks to them through the manifest, the SDK and the UI kit, so each can change without the rest.
