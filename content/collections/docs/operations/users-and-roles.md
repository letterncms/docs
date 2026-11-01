---
id: 01m5wnc9y6x6a2key5cx74nqer
title: Users and roles
position: 1
description: Invite people, give them roles, and decide exactly what each role may do — down to a single collection.
---
## Users

Add people under **Users**. Without a password, Lettern emails an invitation link to set one. People manage their own name, password, two-factor authentication and API tokens under **Account**.

**Super administrators** may do everything regardless of role; keep that to one or two people.

Someone whose roles don't include **Access the admin** is a site visitor. They appear under **Visitors** and use the [public account pages](/operations/public-accounts) instead of the admin. The `member` role is there for them, and pages can be [limited to a role](/content/gated-content).

Entry authorship is separate from roles and edit history. Editors can assign or clear an entry's author through its details panel; see [Entries](/content/entries#entry-details).

Admin user pickers use `users/lookup`, available with `admin.access`. It returns paginated `PersonSummary` records containing only `id`, `name`, `initials` and `avatar`. This lets editors find an author without access to user-management records, email addresses or roles. Use the protected user-management abilities when you need to administer accounts.

### Profile fields

Every account has a name, an email and roles. For anything else — a bio, a job title, a photo — add fields under **Users → Profile fields**, with the same field editor collections use. They are stored in `content/users.yaml`; people fill them in under **Account**, admins in the user dialog. Required profile fields may stay empty until someone completes their profile. Agents read and change them through `users/fields`, and `data` on `users/update` and `account/update`.

## Roles

Roles are lists of permissions, edited under **Settings → Roles** (from the `letterncms/users` module) and stored in `config/roles.yaml` — a settings namespace like any other, so agents change them with `settings/update`. The Administrator role always exists and keeps every permission. Lettern starts with three:

| Role | Can |
|---|---|
| Administrator | Everything. |
| Editor | All content, media, menus, forms, comments and publishing the site. |
| Author | Write and edit content and upload media, but not publish; comment. |

## Permissions

Permissions are dotted names; `*` matches any part:

| Permission | Allows |
|---|---|
| `admin.access` | Signing in to the admin. |
| `entries.pages.view`, `.create`, `.edit`, `.publish`, `.delete` | Working with one collection — `entries.*.edit` for all of them. `entries.templates.*` and `entries.components.*` decide who designs templates and components. |
| `media.view`, `media.upload`, `media.edit`, `media.delete` | Media. |
| `globals.view`, `globals.edit`, `globals.manage` | Global sets: reading, changing values, creating sets and changing their fields. |
| `collections.manage` | Creating and changing collections and fieldsets. |
| `users.view`, `users.manage`, `tokens.manage`, `audit.view` | People, tokens and the audit log. |
| `settings.manage`, `packages.manage` | Settings, the design system, modules and plugins. |
| `site.build` | Publishing the whole site. |
| `blocks.html` | Adding raw HTML blocks — only for trusted people. |
| `site.code` | Editing the site's custom CSS and JavaScript — only for trusted people. |

Each permission belongs to the module or plugin that registers it, so switching one off removes its permissions from **Roles** too. Plugins register their own (`forms.view`, `navigation.manage`, `comments.moderate`, `assistant.use`…); **Roles** lists every permission with a description. A user's permissions are the union of their roles. API tokens can only narrow them further.
