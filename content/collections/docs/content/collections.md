---
id: 01m5wmrf4tpyhxb0sn1y43468e
title: Collections
position: 0
group: 'Model'
description: A collection is a content type — its fields, its URLs, how entries are ordered and where they are stored.
---
Create collections in **Collections** in the admin, ask an agent to, or write the YAML yourself. In the admin, start with a name and structure. **Advanced** lets you override the handle, entry name, URL pattern, template and storage. The template picker offers existing templates and shows the inherited template; creation does not invent a template handle. After creation, use **Fields** to define the content and **Settings** for naming, organization and publishing. With the blocks plugin enabled, new collections start with an explicit `content` field of type `blocks` as their body. Without it, collections can contain structured fields only. Each collection is one file in `content/collections/`:

```yaml
# content/collections/posts.yaml
title: Posts
singular: Post
icon: article
structure: dated
route: '/blog/{slug}'
template: post
body: content
fields:
  - handle: content
    type: blocks
  - handle: tags
    type: tags
    section: sidebar
```

## Options

`collections/options` returns `defaults` (the initial definition contributed by active plugins) and `settings` (the settings fields and choices). Creators apply `defaults` before their explicit values, then pass the definition to `collections/save` with `createOnly: true`. The browser does not invent content fields, and saving an existing collection does not inject new defaults into its blueprint. Plugins can contribute starting definitions through `collections.defaults`; a collection can still remove its body and use fields only.

| Key | Meaning |
|---|---|
| `title`, `singular`, `icon`, `description` | How the collection appears in the admin. |
| `structure` | `list` (ordered by `sort`), `dated` (newest first) or `tree` (nested, ordered by hand — for pages). |
| `route` | The URL pattern. Leave it out for content that has no pages of its own, like team members or testimonials. |
| `home` | For trees: the slug of the entry that becomes `/`. |
| `template` | The slug of the [template](/design/templates) that frames entries. Omit or leave empty to inherit: Lettern uses `default`, or renders the content alone when there is no default template. The picker offers existing templates and shows the fallback in use. A missing explicit handle remains visible with a warning until you choose another template or the inherited value. Entries can override it with a `template` field (`type: select`, `dynamic: templates`). Its empty choice shows the inherited collection template by name; clearing an override restores that inheritance. |
| `section` | The sidebar section it is listed in: `content` unless set. The collection is pinned there unless it is a `system` collection, which waits under **More** — people pin, unpin and reorder it in their own sidebar. |
| `nav_order` | Default place in its section (integer, lower first; `10` when omitted). Starter Pages and Blog explicitly use `10` and `20`. A sidebar someone arranged themselves, or the default an admin saved for everyone, overrides it. |
| `body` | The explicit main-content field handle. A `blocks` body uses the shared block workspace. Collections without a body use a field form; Lettern never guesses from field order. |
| `sort` | Field to sort lists by; prefix with `-` for descending. |
| `default_view` | Default entry view: `table` (default), `grid` or `calendar`. Set it in **Settings → Default display → Default view**. A person’s saved view takes precedence. |
| `default_columns` | Default display fields for tables and cards. Omit or set to `null` for automatic fields; `[]` shows only the title. Use built-in IDs (`uri`, `status`, `translations`, `author`, `published`, `updated`) and `field:<handle>` for blueprint fields. Personal choices take precedence. |
| `driver` | `database` (default) or `files` — see below. |
| `revisions` | `false` turns off revision history. |
| `fields` | The blueprint — see [Fields](/content/fields). |

## Collection views

Every collection has **Table**, **Grid** and **Calendar** views, regardless of its structure or storage driver. Tables show **Status**, **Published** and **Updated** by default, plus **URL** for routable collections and any configured listing fields. **Author** remains available in **Display** but is not part of the automatic display. Explicit collection defaults and personal choices that include Author keep showing it; entries without attribution show **Unassigned**. Use **Display** to choose columns and sorting; your choices are saved per collection.

Bulk actions report each failed entry and its reason. Failed entries remain selected, while successful entries leave the selection, so you can retry only the failures.

Configure the shared starting view and fields in **Collections → your collection → Settings → Default display**. The picker offers built-in metadata and supported collection fields, with field handles shown alongside their labels. Titles always stay visible. Cards show selected fields, including images and excerpts; the calendar groups entry titles by the date selected in Display. A person can return to the shared view, sort and fields with **Display → Reset display**.

```yaml
default_view: grid
default_columns:
  - status
  - field:category
  - field:cover
  - published
```

`default_columns` replaces the automatic display. Without it, existing `listing` fields are still added to the standard columns. Unknown or removed columns are ignored when rendering; they do not prevent a collection from loading. Only fields that have compact display renderers are offered (for example, text, numbers, dates, media and relationships).

Calendar uses **Published** by default; choose **Updated** under **Display → Calendar date**. Entries without the selected date appear under **No date**. The same calendar, view controls and reset action are available across all overviews. Structure controls the collection's default order and nesting, rather than which views or publication columns are available.

## Routes

A route is a URL with placeholders:

| Placeholder | Becomes |
|---|---|
| `{slug}` | The entry's slug. |
| `{parent_uri}` | The slugs of a tree entry's ancestors, e.g. `about/team`. |
| `{year}`, `{month}`, `{day}` | From the publish date. |
| `{id}` | The entry's id. |
| `{field}` | Any field's value, slugified — `/docs/{section}/{slug}`. |

When an entry's URL changes — renamed, moved in the tree, or the route itself changes — Lettern updates every affected URL, and the SEO plugin adds a redirect from the old one.

## Database or files

With `driver: files`, entries are Markdown files with YAML frontmatter in `content/collections/<handle>/`. Tree entries nest in folders (`about/team.md` is a child of `about.md`), translations live in a folder per language. The body field is the Markdown below the frontmatter — block fields are written as [Block Markdown](/editing/block-markdown).

```markdown
---
id: 01jc8w6m3x9k2h4v5t7r0p1q3s
title: Team
position: 1
---
We are six people in Amsterdam.
```

Files make content reviewable in pull requests; these docs are written that way. Unpublished changes to an already-published file entry are kept in `storage/drafts/`, so autosave preserves its published Markdown until you publish again. New draft entries are stored as Markdown files with draft status.

## Deleting a collection

Deleting an empty collection removes its definition. A non-empty collection requires an explicit confirmation to delete its entries too; the admin shows the entry count before you confirm. This removes the collection and its content, rather than hiding stored entries for them to return later.

API clients must pass `deleteEntries: true` to `collections/delete` for a non-empty collection. Entry deletion runs through the content lifecycle so drafts, revisions and plugin-owned entry data are cleaned up, and published output is removed or rebuilt as needed. Plugin-provided system collections remain protected.

## Templates and components

Two collections come with the blocks plugin: **Templates** (`templates`) and **Components** (`components`), both stored as files and opening in the shared block editor. They are marked `system` — they can't be deleted — but a site can redefine them in `content/collections/templates.yaml` or `components.yaml`, for example to add a field. See [Templates](/design/templates) and [Components](/design/components).

Plugins add collections the same way, with the `collections` filter — see [Plugins](/plugins/how-plugins-work#collections).

## Reusing fields

Put fields you use in several collections in a **fieldset** (`content/fieldsets/<handle>.yaml`) and import it:

```yaml
fields:
  - import: seo
  - import: address
    prefix: billing_
```
