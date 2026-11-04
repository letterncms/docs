---
id: 01m5wn8rammpwmg59hge021ebm
title: Showing content
position: 4
description: Connect blocks to your content, so pages show their own title, the latest posts or your menu, in your design.
---
Much of what a page shows isn't typed into the page. A template shows each page's own title. A menu lists your links. A home page lists the latest dishes. In Lettern, you design a block once and connect it to that content, and the content fills it in.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"One card designed inside a Repeat, times every dish in the collection, makes a page with one card per dish.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Dish card</b><span class=\"docs-card__field\">Name</span><span class=\"docs-card__field\">Price</span></div><b>Your design</b><small>One card, inside a Repeat</small></div><span class=\"docs-fig__op\">×</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Grilled turbot</span><em>€34</em></div><div class=\"docs-card docs-card--row\"><span>Six oysters</span><em>€21</em></div><div class=\"docs-card docs-card--row\"><span>Lemon tart</span><em>€9</em></div></div><b>Your content</b><small>Every dish in the collection</small></div><span class=\"docs-fig__op\">=</span><div class=\"docs-fig__step\"><div class=\"docs-mock docs-mock--live\"><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i></div><b>The page</b><small>One card per dish</small></div></div></figure>"}}
:::

When an editor adds a dish, it appears on the page in your design. Nobody has to touch the layout.

## Show a field in a block

1. Select the block, like a heading, and open its **Content** tab.
2. Point at the setting you want to fill, like its text, and press the database icon that appears: **Connect to Data**.
3. Pick what it shows from the list: the page's **Title**, a **Published Date**, the **Site Name**, one of the page's own fields, and more.

The label reads darker and the setting shows where its value comes from. The page shows the real value right away. Press the database icon again to **Disconnect from Data**.

The list only offers what makes sense where the block is: inside a template, the fields of the pages it frames; inside a Repeat, the fields of each item; inside a component, its properties.

### Mix text and data

You can also type into a connected setting. Put data in braces, and write words around it:

- `© {site.year} {site.name}` gives *© 2026 Ondine*.
- `Posted {entry.date|date:M j, Y}` gives *Posted Oct 4, 2026*.

The part after `|` is a filter that changes how a value looks: a date format, a short excerpt, upper case. The list shows a few examples at the bottom, and the full set is under [For developers](#filters).

## Show a list with Repeat

A **Repeat** block shows its contents once for every item of a list: every dish, every link of a menu, every page in a section. You design one item, and the Repeat makes the rest.

![The Repeat block on the home page, listing dishes, with its Content settings on the right.](/media/screens/design-repeat.webp)

1. Add a **Repeat** block where the list should go.
2. In its **Content** tab, choose a **List**, like **Collection Entries**, and set it up: which **Collection**, in what **Order**, and **How Many**. **Only Entries Where** narrows it down with conditions: pick a field, how it compares (*is*, *is not*, *contains*…) and a value.
3. Inside the Repeat, design one item: a card with a heading, an image and a price.
4. Connect each block in it to the item: the heading to the item's **Title**, the image to a photo field, the card's link to the item's **Link**.

Style the Repeat itself in **Design** to lay the items out, for example as a grid of three columns that becomes one column on phones.

| List | Repeats for |
|---|---|
| **Collection Entries** | Entries of a collection: the latest posts, all dishes, the projects in a category |
| **Child Pages** | The pages under this page, under its parent, or in its whole section |
| **Breadcrumbs** | The pages above this one, for a breadcrumb trail |
| **Headings on This Page** | The page's headings, for a table of contents |
| **Menu** | The links of a [menu](/content/navigation) |
| **Languages** | Your site's languages, for a [language switcher](/content/languages) |
| **A list in this scope** | A list inside the current item or page, like a post's tags or a menu link's sub-links |
| **Numbers** | A fixed number of times |

Plugins can add their own lists.

### When the list is empty

Type a message in **When Empty**, like *No events planned yet*. Leave it blank to show nothing.

### Lists inside lists

To show sub-menus, put a Repeat inside a Repeat. Give the outer one an **Item Name**, like *link*. The inner one then uses **A list in this scope** with `link.children`, and its blocks can still reach the outer item as `link`.

### Split a long list into pages

Turn on **Split into Pages** for a Repeat of collection entries. Publishing then writes `/page/2`, `/page/3` and so on. Add links after the Repeat and connect them to **Previous Page of a List** and **Next Page of a List**. To load the next items in place instead, see [Load more without a reload](/design/interactions#load-more-without-a-reload).

## Show a block only sometimes

Under **Visibility** in the **Content** tab:

- **Show on the Site** off hides the block from visitors without deleting it.
- **Only If** shows the block only when some data has a value, like a cover image only when the page has one.
- **Hide If** does the opposite.

## Highlight the current link

A menu usually marks the page you're on. Select the link inside the Repeat, open **Advanced** in the **Content** tab and press **Add State from Data**, the **+** beside **States from Data**. This adds a state named *active*: pick **Is this page or above it** as its data.

The link now has the custom state *active* on the current page. Select it on the state track at the top of **Design** and style it, say in bold. See [Custom states](/design/styles#custom-states).

## Let visitors filter a list

Put a Repeat in a **List Filter** block, and visitors can narrow it down right on the page. Add any of these inside the List Filter:

| Block | Does |
|---|---|
| **Filter Search** | A search field. All words must match, and accents don't matter |
| **Filter Choice** | One choice per value of a field, like each category, with how many items have it. **Look** shows them as chips or as a list |
| **Filter Sort** | A menu of orders, such as by name or by price |
| **No Results** | Shown when nothing matches |

Which fields can be filtered, searched and sorted is set on the Repeat itself, as **Filter By**, **Search In** and **Sort By**. These aren't in its settings panel: ask the [assistant](/agents/assistant) to set them, or see [For developers](#filtering-a-repeat).

Choices stay real radio buttons, the filtered list has its own link, like `?category=seo&q=image&sort=name`, and screen readers hear the count. Without JavaScript the controls go and the whole list shows. Don't combine it with **Split into Pages**: it can only filter the items on the current page.

## For developers

### Bindings

A block's `bind` maps a setting to a **path**:

```json
{ "type": "heading", "props": { "level": "1" }, "bind": { "text": "entry.title" } }
{ "type": "image", "bind": { "image": "entry.cover", "visible": "entry.cover" } }
{ "type": "link", "bind": { "label": "item.label", "url": "item.url", "state:active": "item.active" } }
```

| Key | Does |
|---|---|
| A setting (`text`, `url`, `image`, `label`…) | Takes its value from the path |
| `visible`, `hidden` | Renders the block only when the path has (or lacks) a value. On `account`, a page everyone gets the same copy of leaves it to the browser: see [Visitor accounts](/operations/public-accounts#sign-in-and-my-account-in-your-header) |
| `state:<name>` | Adds the custom state `is-<name>` when the path has a value |
| `attr:<name>` | Sets an attribute (`attr:aria-label`, `attr:href`, `attr:title`, `attr:open` on a `details`, `aria-*`, `data-*`…) |
| `style:<property>` | Sets one style inline: `style:backgroundImage` with an image field makes a cover background |
| `values.<handle>` | On a component instance: one of its [properties](/design/components#for-developers) |

Text from data is escaped. End a path with `|raw` to keep its HTML (a rich text field). Text with braces mixes words and data: `"Posted {entry.date|date:M j, Y} in {entry.category}"`.

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

### Paths

| Path | Holds |
|---|---|
| `entry.*` | The page: `title`, `url`, `slug`, `date`, `updated`, `collection`, `locale`, any field by handle, and `parent`, `children`, `ancestors`, `root`, `prev`, `next` (other entries: `entry.next.url`), `current` (this is the page being rendered) and `active` (it is, or sits above it) |
| `site.*` | `name`, `url`, `description`, `locale`, `locales`, `year` |
| `globals.<set>.<field>` | A [global set](/content/globals) value in the page's language |
| `page.*` | `uri` of the page being rendered, `number` for paginated listings, `markdown`: the URL of its [Markdown version](/operations/seo-and-geo) |
| `item.*`, `index`, `first`, `last` | Inside a Repeat: the current item, its position, whether it is the first or last |
| `props.*` | Inside a component: its properties |
| `pagination.*` | After a paginated Repeat: `current`, `total`, `prev`, `next`, `count` |

`prev` and `next` follow reading order: depth-first for trees (like these docs), oldest to newest for dated collections.

### Repeat

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
| `children` | `of`: `entry` (this page), `item` (the outer item), `parent` (this page's parent) or `root` (the top of this page's branch) | Child entries |
| `breadcrumbs` | `self`: include this page | The pages above this one |
| `headings` | `depth`: down to H2, H3 or H4 | `text`, `id`, `level`, `url` |
| `menu` | `menu`: a menu | `label`, `url`, `newTab`, `current`, `active`, `children` |
| `languages` | — | `locale`, `name`, `url`, `current` |
| `list` | `path`: any list in scope (`item.children`, `entry.tags`, `props.items`) | Whatever the list holds |
| `numbers` | `count` | `number` |
| `cms-facts`, `cms-packages`, `cms-modules`, `cms-abilities` | `limit` (abilities) | Counts, first-party plugins, the admin's modules and abilities of this site |
| `cms-ability-groups`, `cms-block-categories`, `cms-field-types` | — | The installation's abilities, blocks and field types, each with a table of its options. The reference pages of these docs are designs over them |

The Repeat's own props: `tag` (`div`, `ul`, `ol`, `section`, `nav`), `as` (the item name, default `item`), `empty` (the **When Empty** text), `group_by`, `filter_by`, `search_in` and `sort_by`.

- **Where**: `where` narrows `entries` by any field, as a list of `{"field": "category", "op": "=", "value": "{entry.category}"}`. `op` is one of `=`, `!=`, `<`, `>`, `<=`, `>=`, `like`, `in`, `not in`, `contains`, `null` and `not null`, and the value may use data as in text.
- **Groups**: `group_by` names a field of the items. The Repeat then runs once per group, in the order groups first appear, with `item.label` and `item.items`; nest a Repeat with `source: "list", path: "item.items"` for the items. Items without a value share a group with an empty label.
- **Sections**: in a tree, `source: "children", of: "root"` lists the section the page is in from any depth, and `state:active` bound to `item.active` marks the section or link the reader is in. This documentation's navigation is built that way.
- **Pagination**: with `paginate` on, the static build writes `/page/2`, `/page/3`…; bind links after the Repeat to `pagination.prev` and `pagination.next`.
- **Rebuilds**: a page records the collections, entries, menus and globals it reads, so publishing a post rebuilds the pages that list it and nothing else.

Lettern describes itself with the same sources anyone can use: this documentation and lettern.org have no plugin of their own for their reference pages and facts. Plugins add their own sources: see [Data sources](/plugins/how-plugins-work#data-sources).

### Filtering a Repeat

In a **List Filter**, the Repeat's `filter_by` lists the fields its **Filter Choice** blocks use (`item.category, item.tags`), `search_in` the fields **Filter Search** looks through (`item.title, item.summary`), and `sort_by` the fields **Filter Sort** can order by (`item.title, item.price_minor`). A **Filter Sort** option names a `sort_by` field and a direction; an option with no field is the order the Repeat already has, so make that the first.
