---
id: 01m5wnc9y6x6a2key5cx74nqer
title: Users and roles
position: 3
description: Let your clients and team in, each with exactly the access they need, down to a single collection.
---
Everyone who works on the site gets their own sign-in. A **role** decides what they can do: your team may change everything, while a client only updates their menu and photos, and never touches the design.

![A role made for a client: the restaurant team can change dishes and upload photos, nothing else.](/media/screens/operations-roles.webp)

## Invite someone

1. Open **Settings → Users** and press **Invite User**.
2. Fill in their name and email, and choose one or more **Roles**. Only roles that open the admin are offered.
3. Press **Send Invitation**.

They get an email with a link to set their password. It works for 7 days, and **Resend Invitation** sends a new one. Invitations need [working email](/operations/email).

## Choose a role

Lettern starts with these roles. Change them, or add your own.

| Role | Can |
|---|---|
| **Administrator** | Everything, including users, plugins and settings. |
| **Editor** | All content, media, menus, forms and comments, and publishing the site. |
| **Author** | Write and edit content and upload media, but not publish. |
| **Visitor** | Nothing in the admin. For visitors with an account on your site. |

Someone with more than one role can do everything any of them allows.

## Make a role for your client

Most clients need less than an Editor. Give them a role that fits.

1. Open **Settings → Roles** and press **New Role**.
2. Name it, like *Restaurant team*, and describe it in a few words.
3. Tick what it may do. The collections are one table, with **View**, **Create**, **Edit**, **Publish** and **Delete** for each, so a role can be limited to just the dishes. A group's **All** ticks or clears all of it, a collection's name its row, and **All Collections** a column.
4. Press **Save** in the bar at the bottom, or `⌘S`, and give the role to your client under **Users**.

Permissions are grouped by what they're about, **Admin** first. To start from a role you have, choose **Duplicate Role** in its menu; **Delete Role** is there too. The number beside a role is how many people hold it. The **Administrator** role always keeps every permission, so nobody can lock the site out.

::: callout {"props":{"tone":"tip","text":"To keep the design as it is, give a client only the collections they write in, like Dishes, and leave out Templates, Components and the settings."}}
:::

## Team and visitors

**Users** has your **Team**, the people who can open the admin, and your **Visitors** on tabs of their own. A visitor is someone with an account on your site but no admin access, like a customer or a member. They use the [account pages](/operations/public-accounts) on your site, and pages can be [limited to them](/content/gated-content).

## Suspend or remove someone

Click a person's row to open them. Besides their name, email and roles, the dialog has:

- **Suspend**, which stops them signing in straight away. **Reactivate** lets them back in.
- **Delete User**, which takes away their access for good. The content they wrote stays.
- **Resend Invitation**, for someone who hasn't signed in yet.

Nobody can take away their own roles or super admin status here and lock themselves out. Another administrator can.

## Super admins

A **Super Admin** can do everything, whatever their roles say. Only another super admin can make someone one, with the **Super Admin** switch in their dialog. Keep it to one or two people.

## Add fields to profiles

Every person has a name, an email and roles. To add more, like a job title, a bio or a photo, open **Users**, then the **Profile Fields** tab, and press **Add Field**. You add them with the same field editor as collections, and save from the bar at the bottom. People fill them in under **Account**.

## Your own account

Under **Account**, at the top of **Settings**, everyone manages their own name, email and language, their password and [two-factor authentication](/operations/security) under **Security**, the AI agents connected as them under **Agents**, and their tokens under **API Tokens**. The theme is in the menu under your name.

## For developers

### Roles and permissions

Roles are stored in `config/roles.yaml`, a settings namespace like any other, so agents change them with `settings/update`. A role is a label, a description and a list of permissions. Permissions are dotted names, and `*` matches any part:

| Permission | Allows |
|---|---|
| `admin.access` | Signing in to the admin. A role without it is a visitor's role. |
| `entries.pages.view`, `.create`, `.edit`, `.publish`, `.delete` | Working with one collection. `entries.*.edit` covers all of them. `entries.templates.*` and `entries.components.*` decide who designs templates and components. |
| `media.view`, `media.upload`, `media.edit`, `media.delete` | Media. |
| `globals.view`, `globals.edit`, `globals.manage` | Globals: reading, changing values, creating globals and changing their fields. |
| `collections.manage` | Creating and changing collections and fieldsets. |
| `users.view`, `users.manage`, `tokens.manage`, `audit.view` | People, tokens and the audit log. |
| `settings.manage`, `packages.manage` | Settings, the design and plugins. |
| `site.build` | Publishing the whole site. |
| `blocks.html` | Adding raw HTML blocks. Only for trusted people. |
| `site.code` | Editing the site's custom CSS and JavaScript, its [scripts, styles and libraries](/design/code), and putting a script or a persist name on a block. Only for trusted people. |

Each permission belongs to the module or plugin that registers it, so switching one off removes its permissions from **Roles** too. Modules and plugins register their own (`navigation.manage`, `comments.moderate`, `forms.view`, `assistant.use`, `analytics.view`…). API tokens can only narrow a person's permissions, never widen them.

The default roles in full: Editor has `admin.access`, `entries.*`, `globals.*`, `media.*` and `navigation.*`, plus `site.build`, `comments.view`, `comments.create`, `comments.moderate` and `assistant.use` from the modules that bring them, and what plugins give it, such as `forms.*` and `analytics.view`. Author has `admin.access`, `entries.*.view`, `.create` and `.edit`, `media.view` and `media.upload`, plus `comments.view`, `comments.create` and `assistant.use`. Visitor (handle `visitor`) has none. A permission of a module that's off isn't in them. Neither role has `site.code` (**Edit Custom CSS and JavaScript**): whoever holds it can run scripts as anyone who opens the site, the page builder or a preview, administrators included, so it stays the administrators' unless you give it to someone you trust as much.

### Profile fields

Profile fields are stored in `content/users.yaml`. Required ones may stay empty until someone completes their profile. Agents read and change them through `user-fields/get` and `user-fields/save`, and `data` on `users/update` and `account/update`. To let visitors edit a field on the site, see [Visitor accounts](/operations/public-accounts).

### Looking people up

Entry authorship is separate from roles and edit history: see [Entries](/content/entries#entry-details). Admin user pickers use `people/list`, available with `admin.access`. It returns paginated `PersonSummary` records with only `id`, `name`, `initials` and `avatar`, so editors can find an author without seeing email addresses or roles. Use the user-management abilities to administer accounts.
