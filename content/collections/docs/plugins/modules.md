---
id: 01m5ykcdmdzm1ban690v4rpzsq
title: Modules
position: 4
description: The admin itself is a set of modules, built exactly like plugins. Switch off what a site doesn't need.
---
Lettern has no separate "core admin". Every screen you use, from the content lists and the entry editor to users, settings and the home screen, comes from a **module**: a package inside `letterncms/cms`, built exactly like a [plugin](/plugins/how-plugins-work).

A module registers its abilities, permissions, settings, sidebar items and screens through the same public API you use, and nothing else knows it by name. So you can switch off the ones a site doesn't need, and read any of them to learn how to build your own.

## The modules

| Module | What it adds | Can be off |
|---|---|---|
| `letterncms/admin` | The admin itself: its frame (sidebar, command palette, sign-in), design tokens and the primitives in `@letterncms/ui` | No |
| `letterncms/content` | Entry lists and the entry editor, drafts, publishing, history, search; one sidebar item per collection | No |
| `letterncms/account` | Each person's profile, password, two-factor sign-in, appearance and API tokens | No |
| `letterncms/settings` | The settings pages (one per namespace in the settings sidebar) and the `settings/*` abilities | No |
| `letterncms/packages` | The **Modules** screen, the store, updates and the `packages/*` abilities | No |
| `letterncms/license` | Shown as **Paid Plugins**. Checks the keys of paid plugins, and adds the **Licence** screen and the `license/*` abilities once one is on. It never touches the public site. `letterncms/packages` needs it | No |
| `letterncms/dashboard` | The home screen: a greeting, quick-create and the widgets each person arranges | Yes: the admin opens on the first pinned sidebar item |
| `letterncms/collections` | Creating collections and editing their fields | Yes: collections stay as `content/collections/*.yaml` |
| `letterncms/globals` | Global sets, their fields and `/api/v1/globals/<handle>` | Yes |
| `letterncms/users` | The Users screen, invitations, roles and profile fields | Yes: accounts and `config/roles.yaml` keep working |
| `letterncms/audit` | The audit log: who changed what, when, from where | Yes: nothing is written |

The required modules are what Lettern needs to keep working: without them there is no admin, and nobody could edit content, secure their account, change a setting or switch a module back on. Everything else is yours to remove. A site with only the required modules and no plugins is a complete, very small CMS.

## Switch a module off

Open **Modules** in the admin (plugins and modules each have a tab), use the `packages/enable` and `packages/disable` abilities, or edit `config/plugins.yaml`:

```yaml
enabled:          # plugins that run
  - letterncms/blocks
  - letterncms/site
disabled:         # modules that don't
  - letterncms/audit
  - letterncms/dashboard
```

Modules are on unless they're listed under `disabled`; plugins are on when they're listed under `enabled`.

A module others need can't be switched off before them: `letterncms/collections` needs `letterncms/content`. Data is kept, so when you switch a module back on, its items return to the places admins gave them.

## Configure a module

A module's options are a [settings](/plugins/settings) namespace like any plugin's, opened from its row in **Modules** or under **Settings**:

| Module | Settings |
|---|---|
| `letterncms/content` | Entries per page, autosave delay (0 = only ⌘S), revisions kept per entry |
| `letterncms/audit` | How long entries are kept, whether reads are recorded too |
| `letterncms/users` | Roles and their permissions |
| `letterncms/dashboard` | The default home screen for everyone (**Settings → Admin**; arranged on the home screen) |

Values a screen needs reach every admin user through the manifest (`useConfig('content')` in `@letterncms/sdk`); the settings themselves stay behind `settings.manage`.

## Who registered what

While a package registers and boots, it's the current scope, so the abilities and settings it adds record it as their owner (`package` in `abilities/list` and `settings/list`). The settings button on a row in **Modules** comes from there.

## Build one

A module is a plugin that ships with Lettern: the same `composer.json` (`type: cms-plugin`), the same provider (`extends Cms\Packages\Plugin`), the same admin module. Only three things differ:

- It lives in `modules/` of `letterncms/cms`.
- `"required": true` in `extra.cms` marks the ones that may not be switched off.
- It doesn't have to bring a home-screen widget, as every plugin must. Most do anyway.

If you know how to write a plugin, you know how to write a module. Read `modules/audit` (a provider, one ability, one screen, one setting) next to [Your first plugin](/plugins/your-first-plugin).

The `admin` module provides almost no screens of its own: it's what the others draw in. It only talks to them through the manifest, the SDK and the UI kit, so each can change without the rest.
