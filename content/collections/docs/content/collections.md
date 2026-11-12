---
id: 01m5wmrf4tpyhxb0sn1y43468e
title: Collections
position: 0
description: Make your own kinds of content, like surveys, blog posts or team members, each with the fields it needs.
---
A collection is one kind of content on your site: blog posts, team members, projects, surveys. You decide which fields it has, and everyone then fills in a simple form. Every item in it, each post or each survey, is an **entry**.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A collection called Surveys defines the fields. Each survey is an entry that fills them in.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Surveys</b><span class=\"docs-card__field\">Place</span><span class=\"docs-card__field\">Summary</span><span class=\"docs-card__field\">Plate</span></div><b>Collection</b><small>The fields every survey has</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>The Slack Hour</span><em>Zeebrugge</em></div><div class=\"docs-card docs-card--row\"><span>Forty Knots of Nothing</span><em>De Panne</em></div><div class=\"docs-card docs-card--row\"><span>Ground Truth</span><em>Kortrijk</em></div></div><b>Entries</b><small>One for each survey</small></div></div></figure>"}}
:::

Pages are a collection too. Your templates then show the entries in your design, so the people filling them in never have to think about layout.

## Create a collection

1. Open **Collections**, under **Design** in the sidebar, and press **New Collection**.
2. Give it a name, like *Surveys*.
3. Choose a **Structure** (see below).
4. Press **Create Collection**.

![Creating a collection: a name and a structure are all it takes.](/media/screens/content-new-collection.webp)

The collection opens on its **Fields**, ready for the next step, and it appears in the sidebar, under **Content**, for everyone allowed to see it.

Under **Advanced** you can also set the **Handle** (the name used in code and file names), the **Entry Name** (*Survey* for *Surveys*), the **URL Pattern**, the **Template** and the **Storage** (the database, or files you can keep in git). The entry name, URL pattern and template can be changed later, in the collection's **Settings**.

### Pick a structure

| Structure | Best for | Order |
|---|---|---|
| **List** | Surveys, team members, products | Alphabetical, or a field you choose |
| **Dated** | Blog posts, news, events | Newest first |
| **Tree** | Pages that nest, like *About → Team* | By hand, drag to reorder |

## Add fields

Fields are the questions the form asks: a place, a plate, a short summary. On the collection's **Fields** tab, press **Add Field**, pick a type and give it a label. Drag fields to put them in order, then press **Save** in the bar that appears at the bottom (or `⌘S`).

![The Surveys collection's fields: report, summary, sheet number, discipline, client, place and more.](/media/screens/collection.webp)

If the page builder is on, a new collection starts with a **Content** field. That's where an entry is built from blocks, just like a page. Remove it if your entries only need simple fields. See [Fields](/content/fields) for every option.

## Entries of several kinds

Sometimes one collection holds entries that need different fields: an event that is on site or online, a post that is an article or a video. Give the collection a **blueprint** for each kind.

On the collection's **Fields** tab, **Blueprints** is a switch above the fields. Press **+** (**Add Blueprint**), name it, and build its fields in the same editor, with every option. Switch between blueprints to edit each one; **Remove Blueprint** takes one away, and says first how many entries were made with it.

From then on, **New** asks which kind of entry to make, wherever you press it: the list, the command palette, the home screen. An entry keeps the blueprint it was made with, and the editor shows that blueprint's fields. A collection with one set of fields works as before.

## Give entries their own pages

A blog post needs its own address; a team member usually doesn't. Open the collection's **Settings** tab and set the **URL Pattern** under **Publishing**:

- `/blog/{slug}` gives each post an address like `/blog/hello-world`.
- Leave it empty for content without pages of its own, like testimonials or team members. You show those inside other pages instead.

Next to it, choose the **Template** that frames each entry. Leave it empty to use your site's default template. See [Templates](/design/templates).

## Fill it in

Open the collection from the sidebar and press the button named after its entries, like **New Survey**. You, your team and your clients fill in the form, and the design takes care of itself.

![Filling in a survey: one simple form, with the fields the collection asks for.](/media/screens/entry.webp)

See [Entries](/content/entries) for saving, publishing and scheduling.

## Choose how the list looks

Every collection can show its entries as a **Table**, a **Grid** of cards or a **Calendar**. Use **Display** above the list to switch, pick the columns or fields to show, and sort. Your choices are saved for you, per collection.

![The list of surveys in a table.](/media/screens/entries.webp)

To keep more than one arrangement, press **Views**, beside **Display**, choose **Save View** and give it a name. It keeps what the list is narrowed to (status, language, search), its order, its columns and whether it is a table, a grid or a calendar. Choose a view in that menu to put the list back that way: the button then shows its name. **Rename View** and **Delete View** in the same menu work on any of your views: with more than one, they ask which. Views are yours alone and come with your account to every browser.

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
| `default_view` | `table` (default), `grid` or `calendar`. What a person chose in **Display** wins. |
| `default_columns` | Fields shown in tables and cards. Omit or `null` for automatic, `[]` for the title only. Use `uri`, `status`, `translations`, `author`, `published`, `ends`, `updated`, and `field:<handle>` for your own fields. Personal choices win. |
| `driver` | `database` (default) or `files` (see below). |
| `revisions` | `false` turns off revision history. |
| `fields` | The blueprint: see [Fields](/content/fields). |
| `blueprints` | More sets of fields, for entries that come in kinds: see [Several blueprints](#several-blueprints). |
| `taxonomy` | `true` makes the collection a [taxonomy](/content/taxonomies): its entries are terms that `terms` fields pick from. The **Taxonomy** switch in its settings. |
| `archives` | A page per term of a taxonomy that lists this collection's entries filed under it: `{topics: '/blog/topics/{slug}'}`. See [Give a collection a page per term](/content/taxonomies#give-a-collection-a-page-per-term). **Term Archives** in its settings. |

### Several blueprints

Beside `fields`, a collection can name more sets of fields, for entries that come in kinds: an event that is on site or online, a post that is an article or a video.

```yaml
fields:
  - { handle: place, type: geo, label: Place }
blueprints:
  online:
    title: Online event
    fields:
      - { handle: stream, type: url, label: Stream, required: true }
```

The **Blueprints** switch in the fields editor writes this. An entry is made with one, `blueprint` on `entries/create`, and keeps it. Its defaults, its validation, its shared fields and what templates get all follow that blueprint. A translation or a copy has the blueprint of its source, and an entry made without one has the collection's own `fields`.

```bash
php cms run entries/create --input='{"collection":"events","blueprint":"online","title":"Stream night","data":{"stream":"https://example.com/live"}}'
```

An entry says which it has, in `blueprint` (`null` for the collection's own fields), and in a file collection `blueprint` is in the front matter. `collections/schema` gives the schemas of each blueprint under `blueprints`, `collections/get` their fields under `resolvedBlueprints`, and `entries/list` filters by `blueprint`. If a blueprint is removed, its entries fall back to the collection's `fields`, so their content survives.

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

`default_columns` replaces the automatic columns. Unknown or removed columns are ignored, so they never stop a collection from loading. Only fields with a compact display (text, numbers, dates, media, relationships and the like) can be shown.

```yaml
default_view: grid
default_columns:
  - status
  - field:category
  - field:cover
  - published
```

### Saved views

A person's saved views are kept with their account and reached through `saved-views/list`, `saved-views/create`, `saved-views/update` and `saved-views/delete`. A view names its list (`entries.<collection>`) and holds its `state`: `query` (the list's search and filters, as they are in the address), `sort`, `columns` (by their key in the list: `uri`, `displayStatus`, `values.<field>`), `view` and `calendarDate`. A filter or a column the list doesn't have is refused; one that is removed later is left out of the view.

### Creating and deleting through the API

`collections/options` returns `defaults` (the starting definition from active plugins) and `settings` (the settings fields and choices). Creators apply `defaults` first, then pass the definition to `collections/save` with `createOnly: true`. Saving an existing collection never injects new defaults. Plugins contribute defaults through the `collections.defaults` filter; the Blocks module adds a `content` field of type `blocks` as the body.

`collections/delete` needs `deleteEntries: true` for a collection with entries. Deleting runs through the content lifecycle, so drafts, revisions and plugin data are cleaned up, and published pages are removed or rebuilt.

When `collections/save` refuses a field (a type that isn't installed, a handle used twice), its `details` say which one, by path: `fields.2.handle`, `fields.0.fields.1.type`. `globals/save` and `fieldsets/save` do the same.

### System collections

The Blocks module brings **Templates** (`templates`) and **Components** (`components`), both stored as files and edited in the block editor. They are `system` collections: they aren't listed under **Collections** and can't be deleted, but a site can redefine them in `content/collections/templates.yaml` or `components.yaml`, for example to add a field. See [Templates](/design/templates) and [Components](/design/components).

The pages plugins bring, like checkout and sign-in, are `system` collections too. They have no sidebar item of their own: **Pages** has a tab for each plugin that brings pages, named after it, beside **Site**, your own pages.

Plugins add collections the same way, with the `collections` filter: see [Plugins](/plugins/how-plugins-work#collections).

### Reusing fields

Put fields you use in several collections in a **fieldset** (`content/fieldsets/<handle>.yaml`) and import it:

```yaml
fields:
  - import: seo
  - import: address
    prefix: billing_
```
