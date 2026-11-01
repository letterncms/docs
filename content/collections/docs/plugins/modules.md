---
id: 01m5ykcdmdzm1ban690v4rpzsq
title: Modules
position: 4
group: 'Admin'
description: The admin is not one program but a set of modules, built exactly like plugins. Switch off what a site doesn't need and configure the rest.
---
Lettern has no separate "core admin". Every screen you use — the content lists, the entry editor, users, settings, the home screen — comes from a **module**: a package inside `letterncms/cms` with the same anatomy as any [plugin](/plugins/how-plugins-work). A module registers its abilities, permissions, settings, sidebar items and admin screens through the public API, and nothing else knows it by name.

| Module | What it adds | Can be off |
|---|---|---|
| `letterncms/admin` | The admin itself: its frame (sidebar, command palette, sign-in), design tokens and the primitives in `@letterncms/ui` | No |
| `letterncms/content` | Entry lists and the entry editor, drafts, publishing, history, search; one sidebar item per collection | No |
| `letterncms/account` | Each person's profile, password, two-factor sign-in, appearance and API tokens | No |
| `letterncms/settings` | The settings pages (one per namespace in the settings sidebar) and the `settings/*` abilities | No |
| `letterncms/packages` | The **Modules** screen, the store, updates and the `packages/*` abilities | No |
| `letterncms/license` | Shown as **Paid Plugins**. Checks the keys of paid plugins, and adds the **Licence** screen and the `license/*` abilities once one is on. It never touches the public site. `letterncms/packages` needs it | No |
| `letterncms/dashboard` | The home screen: a greeting, quick-create and the widgets each person arranges | Yes — the admin opens on the first pinned sidebar item |
| `letterncms/collections` | Creating collections and editing their fields | Yes — collections stay as `content/collections/*.yaml` |
| `letterncms/globals` | Global sets, their fields and `/api/v1/globals/<handle>` | Yes |
| `letterncms/users` | The Users screen, invitations, roles and profile fields | Yes — accounts and `config/roles.yaml` keep working |
| `letterncms/audit` | The audit log: who changed what, when, from where | Yes — nothing is written |

The required modules are what Lettern needs to keep working: without them there is no admin, and nobody could edit content, secure their account, change a setting or switch a module back on. Everything else is yours to remove. A site with only the required modules and no plugins is a complete, very small CMS.

## Switching modules on and off

Open **Modules** in the admin (plugins and modules each have a tab), use the `packages/enable` and `packages/disable` abilities, or edit `config/plugins.yaml`:

```yaml
enabled:          # plugins that run
  - letterncms/blocks
  - letterncms/site
disabled:         # modules that don't
  - letterncms/audit
  - letterncms/dashboard
```

Modules are on unless listed under `disabled`; plugins are on when listed under `enabled`. A module others need (`letterncms/collections` needs `letterncms/content`) cannot be switched off before them. Data is kept: switch a module back on and its items return to the places admins gave them.

## Configuring a module

A module's options are a settings namespace like any plugin's, opened from its row in **Modules** or under **Settings**:

| Module | Settings |
|---|---|
| `letterncms/content` | Entries per page, autosave delay (0 = only ⌘S), revisions kept per entry |
| `letterncms/audit` | How long entries are kept, whether reads are recorded too |
| `letterncms/users` | Roles and their permissions |
| `letterncms/dashboard` | The default home screen for everyone (**Settings → Admin**; arranged on the home screen) |

Values a screen needs reach every admin user through the manifest (`useConfig('content')` in `@letterncms/sdk`); the settings themselves stay behind `settings.manage`.

## Who registered what

While a package registers and boots it is the current scope, so the abilities and settings it adds record it as their owner (`package` in `abilities/list` and `settings/list`). The settings button on a row in **Modules** comes from there.

## Building one

A module is a plugin that ships with Lettern: same `composer.json` (`type: cms-plugin`), same provider (`extends Cms\Packages\Plugin`), same admin module. The only differences are where it lives, `"required": true` in `extra.cms` for those that may not be switched off, and that a module need not bring a home-screen widget (every plugin must) — most do anyway. If you know how to write a plugin, you know how to write a module — read `modules/audit` (a provider, one ability, one screen, one setting) next to [Your first plugin](/plugins/your-first-plugin).

The `admin` module provides almost no screens of its own: it is what the others draw in. It only talks to them through the manifest, the SDK and the UI kit, so each can change without the rest.
