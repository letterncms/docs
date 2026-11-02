---
id: 01m5wn8rammpwmg59hge021ebm
title: Data and Repeat
position: 4
group: 'Data and behaviour'
description: Connect any block to the page's fields, the site, global sets or a list — and repeat blocks for every blog post, menu link or child page.
---
Any block setting can come from data instead of being typed in. In the inspector's **Content** tab, click the database icon next to a setting and pick what it shows. That is how a template shows each page's title, how a navigation bar lists a menu, and how a blog index lists posts.

## Bindings

A block's `bind` maps a setting to a **path**:

```json
{ "type": "heading", "props": { "level": "1" }, "bind": { "text": "entry.title" } }
{ "type": "image", "bind": { "image": "entry.cover", "visible": "entry.cover" } }
{ "type": "link", "bind": { "label": "item.label", "url": "item.url", "state:active": "item.active" } }
```

| Key | Does |
|---|---|
| A setting (`text`, `url`, `image`, `label`…) | Takes its value from the path. |
| `visible`, `hidden` | Renders the block only when the path has (or lacks) a value. |
| `state:<name>` | Adds the custom state `is-<name>` when the path has a value — style it in [Styles](/design/styles#custom-states). |
| `attr:<name>` | Sets an attribute (`attr:aria-label`, `attr:href`, `attr:title`, `attr:open` on a `details`, `aria-*`, `data-*`…). |
| `style:<property>` | Sets one style inline — `style:backgroundImage` with an image field makes a cover background. |
| `values.<handle>` | On a component instance: one of its [properties](/design/components#properties). |

Text from data is escaped. End a path with `|raw` to keep its HTML (a rich text field).

### Text with placeholders

Mix words and data with braces:

```json
{ "type": "paragraph", "bind": { "text": "© {site.year} {site.name}" } }
{ "type": "paragraph", "bind": { "text": "Posted {entry.date|date:M j, Y} in {entry.category}" } }
```

### Filters

| Filter | Example |
|---|---|
| `date:format` | `entry.date\|date:F j, Y` |
| `excerpt:length` | `item.body\|excerpt:140` |
| `upper`, `lower` | `item.label\|upper` |
| `default:text` | `entry.subtitle\|default:Read more` |
| `count` | `entry.tags\|count` |
| `first` | `entry.gallery\|first` |
| `not` | `visible: "entry.cover\|not"` |
| `is:value` | `state:featured: "item.kind\|is:featured"` |
| `raw` | Keep HTML |

## What you can bind to

| Path | Holds |
|---|---|
| `entry.*` | The page: `title`, `url`, `slug`, `date`, `updated`, `collection`, `locale`, any field by handle, and `parent`, `children`, `ancestors`, `root`, `prev`, `next` (other entries — `entry.next.url`), `current` (this is the page being rendered) and `active` (it is, or sits above it) |
| `site.*` | `name`, `url`, `description`, `locale`, `locales`, `year` |
| `globals.<set>.<field>` | A [global set](/content/globals) value in the page's language |
| `page.*` | `uri` of the page being rendered, `number` for paginated listings, `markdown` — the URL of its [Markdown version](/design/seo-and-geo) |
| `item.*`, `index`, `first`, `last` | Inside a Repeat: the current item, its position, whether it is the first or last |
| `props.*` | Inside a component: its properties |
| `pagination.*` | After a paginated Repeat: `current`, `total`, `prev`, `next`, `count` |

`prev` and `next` follow reading order: depth-first for trees (like these docs), oldest to newest for dated collections.

## Repeat

**Repeat** renders its children once for every item of a list. Put one card inside, bind it to `item.*`, and the card repeats:

```json
{
  "type": "repeat",
  "props": { "source": "entries", "collection": "posts", "sort": "-published_at", "limit": 6, "tag": "div" },
  "style": { "base": { "display": "grid", "gridTemplateColumns": "repeat(3, 1fr)", "gap": "token:space.8" }, "mobile": { "gridTemplateColumns": "1fr" } },
  "children": [
    { "type": "box", "props": { "tag": "article" }, "bind": { "link": "item.url" }, "children": [
      { "type": "paragraph", "props": { "tag": "time" }, "bind": { "text": "item.date|date:M j, Y" } },
      { "type": "heading", "props": { "level": "3" }, "bind": { "text": "item.title" } }
    ] }
  ]
}
```

| Source | Settings | Items |
|---|---|---|
| `entries` | `collection`, `sort`, `limit`, `offset`, `parent` (`any`, `top`, `current` page, outer `item`), `hasTag`, `where`, `skipCurrent`, `paginate` | Entries, like `entry.*` |
| `children` | `of`: this page, the outer item, this page's parent, or the top of this page's branch | Child entries |
| `breadcrumbs` | `self`: include this page | The pages above this one |
| `headings` | `depth`: down to H2, H3 or H4 | `text`, `id`, `level`, `url` — a table of contents |
| `menu` | `menu`: a [navigation](/content/navigation) menu | `label`, `url`, `newTab`, `current`, `active`, `children` |
| `languages` | — | `locale`, `name`, `url`, `current` — a [language switcher](/content/languages) |
| `list` | `path`: any list in scope (`item.children`, `entry.tags`, `props.items`) | Whatever the list holds |
| `numbers` | `count` | `number` — repeat a fixed number of times |
| `cms-facts`, `cms-packages`, `cms-modules`, `cms-abilities` | `limit` (abilities) | Counts, first-party plugins, the admin's modules and abilities of this site |
| `cms-ability-groups`, `cms-block-categories`, `cms-field-types` | — | The installation's abilities, blocks and field types, each with a table of its options — the reference pages of these docs are designs over them |

`where` narrows `entries` by any field: a list of `{"field": "category", "op": "=", "value": "{entry.category}"}`. `op` is one of `=`, `!=`, `<`, `>`, `<=`, `>=`, `like`, `in`, `not in`, `contains`, `null` and `not null`, and the value may use data as in text.

### Filtering a Repeat

Put a Repeat in a **List Filter** block and visitors can narrow it down in the page. Set **Filter By** on the Repeat to the fields its choices use (`item.category, item.tags`), **Search In** to the fields search looks through (`item.title, item.summary`) and **Sort By** to the fields it can be ordered by (`item.title, item.price_minor`). Then add:

| Block | Does |
|---|---|
| **Filter Search** | A search field. All words must match, and accents don't matter. |
| **Filter Choice** | One choice per value of a Filter By field, such as `category`, with how many items have it. Options come from the items. **Look** shows them as chips or as a list. |
| **Filter Sort** | A menu of orders. Each option names a Sort By field and a direction. An option with no field is the order the Repeat already has, so make that the first. |
| **Filter Empty** | Shown when nothing matches. |

Choices stay real radio buttons, the result links as `?category=seo&q=image&sort=name`, and screen readers hear the count. Without JavaScript the controls go and the whole list shows. Don't use it with `paginate`: it can only filter the items on the page.

Lettern describes itself with the same sources anyone can use: this documentation and lettern.org have no plugin of their own for their reference pages and facts. Plugins add their own sources — see [Plugins](/plugins/how-plugins-work#data-sources).

- **Nesting** — give the outer Repeat an **Item name** (`as: "link"`) and an inner Repeat with `source: "list", path: "link.children"` renders sub-menus.
- **Groups** — **Group by** (`group_by`) names a field of the items. The Repeat then runs once per group, in the order groups first appear, with `item.label` and `item.items`; nest a Repeat with `source: "list", path: "item.items"` for the items. Items without a value share a group with an empty label.
- **Sections** — in a tree, `source: "children", of: "root"` lists the section the page is in from any depth, and `state:active` bound to `item.active` marks the section or link the reader is in. This documentation's navigation is built that way.
- **Empty lists** show the **When empty** text, or nothing.
- **Pagination** — with `paginate` on, the static build writes `/page/2`, `/page/3`…; bind links after the Repeat to `pagination.prev` and `pagination.next`, or load more items in place with [Load into](/design/interactions#load-into).
- **Rebuilds** — a page records the collections, entries, menus and globals it reads, so publishing a post rebuilds the pages that list it and nothing else.
