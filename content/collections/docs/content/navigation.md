---
id: 01m5wmrf54ajwj8th7vqpcrx9g
title: Navigation
position: 4
description: Build your site's menus from pages and links, with drag and drop. Links to pages keep working when pages move.
---
Menus are the lists of links in your header, your footer or anywhere else. Build them from your own pages and any other links, and drag them into order.

![The main menu, with its links in order.](/media/screens/content-menu.webp)

A menu is a [collection](/content/collections) of the type **Menu**, and each of its links is an entry: its title is the words shown, and its **Link** is where it goes. So links have publishing, history and translations like any page.

## Make a menu

1. Open **Structure** in the sidebar, then **Menus**, and press **New Menu**.
2. Give it a name, like *Main*, *Footer* or *Legal*, and press **Create Menu**.
3. The menu opens on its links. Press **Add Link**, choose the **Link** and press **Add Link** in the dialog.

The link is live at once. Your menus are listed in **Content** in the sidebar, under **Menus**: choose one to open its links.

## Links

A **Link** goes to one of your pages, a full address like `https://…`, a path on your site like `/contact`, a section of a page like `#menu`, an email address, a phone number or a file from the [media library](/content/media). An address that starts any other way, such as `javascript:`, is refused.

**Label** is the words the menu shows. Leave it empty for a link to a page, and the link takes the page's title. To change a link later, open it from the menu's list, as you open an entry.

A link to a **page** follows that page. Rename it or move it, and the menu keeps pointing to the right place. While the page isn't published, its link stays out of the menu on your site, with the links nested under it. When the page is deleted, its link goes too, and what was nested under it moves up a level.

Only published links show on your site: unpublish one to take it out of the menu for a while.

## Order and nest

The menu's list is a tree. Drag links up and down to reorder them, and under another link to nest them, for a dropdown.

A menu nests three levels deep unless you say otherwise: its **Settings** in Structure have **Levels**, from 1 to 5. Nesting a link deeper is refused.

## Add a page to a menu

In the [workspace](/getting-started/workspace), the answer to making, publishing or duplicating a page offers **Add to Menu**: choose the menu, and a link to the page is added at its end.

## Show a menu on your site

A menu appears wherever a **Repeat** block lists it, usually in your header and footer. A new site, from Starter, comes with two: its header shows the menu called *Main*, and its footer the one called *Footer*, so a new link appears there as soon as you add it. See [Showing content](/design/data) to show a menu somewhere else.

The link to the page a visitor is on is marked for screen readers, and you can style it with the **Active** state.

## Menus in other languages

On a site with several [languages](/content/languages), translate a link as you translate a page: open it and press the language button in the toolbar. On a page in that language, the menu shows the translation's words, and a link to an address its own address. A link to a page goes to the page's translation once that is live. A link without a translation shows the original's words.

## Rename or delete a menu

Open **Structure**, then **Menus**, and choose the menu. Its **Settings** tab holds its name, its icon and its levels, and **Delete Collection** is at the end. Renaming keeps its handle, so the Repeat blocks that list it keep showing it. After deleting, they show nothing, so take it out of your templates too.

## For developers

### The menu files

A menu is a collection with `type: menu`, defined in `content/collections/<handle>.yaml` and kept in files unless you choose the database. Its links are entries of a tree, with a required `link` field:

```yaml
# content/collections/main.yaml
type: menu
title: Main
singular: Link
driver: files
max_depth: 3
fields:
  - handle: link
    type: link
    label: Link
    required: true
```

Each link is an entry in `content/collections/<handle>/`. A link to a page names the entry's id, an address its URL:

```markdown
---
# content/collections/main/about.md
id: 01m7k5x058qr15yepc2qjy4atc
title: About
status: published
position: 0
link:
  type: entry
  value: 01m6zz00000000000000000001
---
```

```yaml
link: { type: url, value: '/contact', new_tab: true }
```

Agents work with the links through `entries/create`, `entries/update`, `entries/reorder`, `entries/move` and `entries/delete`, and change the menu itself with `collections/save`. A link nested deeper than `max_depth` is refused.

### Showing a menu

Show a menu with a **Repeat** whose list is the menu, and a **Link** inside bound to each item:

```json
{ "type": "repeat", "props": { "source": "menu", "menu": "main", "tag": "ul" }, "children": [
  { "type": "box", "props": { "tag": "li" }, "children": [
    { "type": "link", "bind": { "label": "item.label", "url": "item.url", "state:active": "item.active" } }
  ] }
] }
```

Each item has `label`, `url`, `newTab`, `current` (this page), `active` (this page or one of its descendants) and `children` for the next level. Nest a Repeat with `source: list` and `path: item.children` for dropdowns. Style the active link with the *active* state: `bind: { "state:active": "item.active" }` sets `data-active` on it, and a class such as `data-active:font-medium` styles it. Links to the current page get `aria-current="page"` automatically.

A page that shows a menu is rebuilt when one of its links changes, and when a page it links to is renamed, moved or unpublished.

### In PHP

`cms_menu('main')` returns the same list, or `null` when the menu doesn't exist.
