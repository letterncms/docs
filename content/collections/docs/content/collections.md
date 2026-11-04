---
id: 01m5wmrf4tpyhxb0sn1y43468e
title: Collections
position: 0
description: Make your own kinds of content, like dishes, blog posts or team members, each with the fields it needs.
---
A collection is one kind of content on your site: blog posts, team members, projects, dishes. You decide which fields it has, and everyone then fills in a simple form. Every item in it, each post or each dish, is an **entry**.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A collection called Dishes defines the fields. Each dish is an entry that fills them in.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Dishes</b><span class=\"docs-card__field\">Price</span><span class=\"docs-card__field\">Description</span><span class=\"docs-card__field\">Photo</span></div><b>Collection</b><small>The fields every dish has</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Grilled turbot</span><em>€34</em></div><div class=\"docs-card docs-card--row\"><span>Six oysters</span><em>€21</em></div><div class=\"docs-card docs-card--row\"><span>Lemon tart</span><em>€9</em></div></div><b>Entries</b><small>One for each dish</small></div></div></figure>"}}
:::

Pages are a collection too. Your templates then show the entries in your design, so the people filling them in never have to think about layout.

## Create a collection

1. Open **Collections**, under **Design** in the sidebar, and press **New Collection**.
2. Give it a name, like *Dishes*.
3. Choose a **Structure** (see below).
4. Press **Create Collection**.

![Creating a collection: a name and a structure are all it takes.](/media/screens/content-new-collection.webp)

The collection opens on its **Fields**, ready for the next step, and it appears in the sidebar, under **Content**, for everyone allowed to see it.

Under **Advanced** you can also set the **Handle** (the name used in code and file names), the **Entry Name** (*Dish* for *Dishes*), the **URL Pattern**, the **Template** and the **Storage** (the database, or files you can keep in git). The entry name, URL pattern and template can be changed later, in the collection's **Settings**.

### Pick a structure

| Structure | Best for | Order |
|---|---|---|
| **List** | Dishes, team members, products | Alphabetical, or a field you choose |
| **Dated** | Blog posts, news, events | Newest first |
| **Tree** | Pages that nest, like *About → Team* | By hand, drag to reorder |

## Add fields

Fields are the questions the form asks: a price, a photo, a short description. On the collection's **Fields** tab, press **Add Field**, pick a type and give it a label. Drag fields to put them in order, then press **Save** in the bar that appears at the bottom (or `⌘S`).

![The Dishes collection's fields: price, course, description, allergens, photo and whether it's on the menu.](/media/screens/collection.webp)

If the page builder is on, a new collection starts with a **Content** field. That's where an entry is built from blocks, just like a page. Remove it if your entries only need simple fields. See [Fields](/content/fields) for every option.

## Give entries their own pages

A blog post needs its own address; a team member usually doesn't. Open the collection's **Settings** tab and set the **URL Pattern** under **Publishing**:

- `/blog/{slug}` gives each post an address like `/blog/hello-world`.
- Leave it empty for content without pages of its own, like testimonials or team members. You show those inside other pages instead.

Next to it, choose the **Template** that frames each entry. Leave it empty to use your site's default template. See [Templates](/design/templates).

## Fill it in

Open the collection from the sidebar and press the button named after its entries, like **New Dish**. You, your team and your clients fill in the form, and the design takes care of itself.

![Filling in a dish: one simple form, with the fields the collection asks for.](/media/screens/entry.webp)

See [Entries](/content/entries) for saving, publishing and scheduling.

## Choose how the list looks

Every collection can show its entries as a **Table**, a **Grid** of cards or a **Calendar**. Use **Display** above the list to switch, pick the columns or fields to show, and sort. Your choices are saved for you, per collection.

![The list of dishes in a table.](/media/screens/entries.webp)

To set the starting view for everyone, open the collection's **Settings** tab and use **Default Display**, then save. Anyone can go back to it with **Display → Reset Display**.

A few details worth knowing:

- Tables show **Status**, **Published** and **Updated**, plus **URL** for collections with their own pages.
- **Author** isn't shown unless you add it. Entries nobody is credited for show **Unassigned**.
- The calendar uses the publish date. Choose **Updated** under **Display → Calendar Date** instead; entries without that date are listed under **No date**.
- When a bulk action fails for some entries, they stay selected with the reason, so you can retry just those.

## Delete a collection

Open the collection's **Settings** tab and press **Delete Collection** at the end of the page, then confirm. If it still has entries, Lettern tells you how many, and the button to confirm says **Delete Collection and Entries**: the entries, their drafts and their history go too. This can't be undone.

## For developers

### The collection file

Each collection is one YAML file in `content/collections/`. You can write it by hand, ask an agent, or use the admin: they all write the same file.

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

### Options

| Key | Meaning |
|---|---|
| `title`, `singular`, `icon`, `description` | How the collection appears in the admin. |
| `structure` | `list` (ordered by `sort`, by title unless set), `dated` (newest first) or `tree` (nested, ordered by hand). |
| `route` | The URL pattern (see below). Leave it out for content without pages of its own. |
| `home` | For trees: the slug of the entry that becomes `/`. |
| `template` | The slug of the [template](/design/templates) that frames entries. Omit or leave empty to inherit: Lettern uses `default`, or renders the content alone when there is no default template. A missing template stays visible with a warning until you choose another. Entries can override it with a `template` field (`type: select`, `dynamic: templates`); clearing that field restores the collection's template. |
| `section` | The sidebar section it is listed in: `content` unless set. Every collection is in the sidebar from the start; people unpin and reorder it in their own sidebar, and what they unpin waits under **More**. The Blocks module's templates and components use `design`. |
| `nav_order` | Default place in its section (integer, lower first; `10` when omitted). A sidebar someone arranged, or the default an admin saved for everyone, overrides it. |
| `body` | The main-content field's handle. A `blocks` body uses the block editor. Without a body, entries use a field form; Lettern never guesses one from field order. |
| `sort` | Field to sort lists by; prefix with `-` for descending. |
| `default_view` | `table` (default), `grid` or `calendar`. A person's saved view wins. |
| `default_columns` | Fields shown in tables and cards. Omit or `null` for automatic, `[]` for the title only. Use `uri`, `status`, `translations`, `author`, `published`, `updated`, and `field:<handle>` for your own fields. Personal choices win. |
| `driver` | `database` (default) or `files` (see below). |
| `revisions` | `false` turns off revision history. |
| `fields` | The blueprint: see [Fields](/content/fields). |

### Routes

A route is a URL with placeholders:

| Placeholder | Becomes |
|---|---|
| `{slug}` | The entry's slug. |
| `{parent_uri}` | The slugs of a tree entry's ancestors, e.g. `about/team`. |
| `{year}`, `{month}`, `{day}` | From the publish date. |
| `{id}` | The entry's id. |
| `{field}` | Any field's value, slugified: `/docs/{section}/{slug}`. |

When an entry's URL changes (renamed, moved in the tree, or the route itself changes), Lettern updates every affected URL, and the SEO plugin adds a redirect from the old one. For a different pattern per language, see [Languages](/content/languages#for-developers).

### Database or files

With `driver: files`, entries are Markdown files with YAML frontmatter in `content/collections/<handle>/`. Tree entries nest in folders (`about/team.md` is a child of `about.md`), and translations live in a folder per language. The body field is the Markdown below the frontmatter; block fields are written as [Block Markdown](/reference/block-markdown).

```markdown
---
id: 01jc8w6m3x9k2h4v5t7r0p1q3s
title: Team
position: 1
---
We are six people in Amsterdam.
```

Files make content reviewable in pull requests; these docs are written that way. New drafts are Markdown files with draft status. Unpublished changes to a published file entry are kept in `storage/drafts/`, so the published Markdown stays as it is until you publish again.

### Default display

`default_columns` replaces the automatic columns. Without it, fields listed under `listing` are still added to the standard columns. Unknown or removed columns are ignored, so they never stop a collection from loading. Only fields with a compact display (text, numbers, dates, media, relationships and the like) can be shown.

```yaml
default_view: grid
default_columns:
  - status
  - field:category
  - field:cover
  - published
```

### Creating and deleting through the API

`collections/options` returns `defaults` (the starting definition from active plugins) and `settings` (the settings fields and choices). Creators apply `defaults` first, then pass the definition to `collections/save` with `createOnly: true`. Saving an existing collection never injects new defaults. Plugins contribute defaults through the `collections.defaults` filter; the Blocks module adds a `content` field of type `blocks` as the body.

`collections/delete` needs `deleteEntries: true` for a collection with entries. Deleting runs through the content lifecycle, so drafts, revisions and plugin data are cleaned up, and published pages are removed or rebuilt.

### System collections

The Blocks module brings **Templates** (`templates`) and **Components** (`components`), both stored as files and edited in the block editor. They are `system` collections: they aren't listed under **Collections** and can't be deleted, but a site can redefine them in `content/collections/templates.yaml` or `components.yaml`, for example to add a field. See [Templates](/design/templates) and [Components](/design/components).

The pages plugins bring, like checkout and sign-in, are `system` collections too. They have no sidebar item of their own: **Pages** lists them under **Built-in Pages**, grouped by plugin.

Plugins add collections the same way, with the `collections` filter: see [Plugins](/plugins/how-plugins-work#collections).

### Reusing fields

Put fields you use in several collections in a **fieldset** (`content/fieldsets/<handle>.yaml`) and import it:

```yaml
fields:
  - import: seo
  - import: address
    prefix: billing_
```
