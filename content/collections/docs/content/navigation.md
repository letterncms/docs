---
id: 01m5wmrf54ajwj8th7vqpcrx9g
title: Navigation
position: 6
group: 'Manage'
description: Build menus from pages and links with drag and drop. Links to pages follow them when they move.
---
Open **Navigation**, create a menu (for example *Main* or *Footer*) and add items:

- **Pages** link to an entry. If the page is renamed or moved, the menu follows; while it is a draft, it stays hidden.
- **Links** go anywhere: `https://…`, `/path`, `#section`, `mailto:` or `tel:`.

Drag items to reorder them, drag sideways to nest them, and choose how many levels the menu allows. Menus are saved as YAML in `content/navigation/`.

## On the site

Show a menu with a **Repeat** whose list is the menu, and a **Link** inside bound to each item — the starter kit's header does exactly this:

```json
{ "type": "repeat", "props": { "source": "menu", "menu": "main", "tag": "ul" }, "children": [
  { "type": "box", "props": { "tag": "li" }, "children": [
    { "type": "link", "bind": { "label": "item.label", "url": "item.url", "state:active": "item.active" } }
  ] }
] }
```

Each item has `label`, `url`, `newTab`, `current` (this page) and `active` (this page or one of its descendants), and `children` for the next level — nest a Repeat with `source: list` and `path: item.children` for dropdowns. Style the active link with the `is-active` state. Links to the current page get `aria-current="page"` automatically.

PHP code reads a menu with `cms_menu('main')` (`null` when it does not exist).

On multilingual sites, page links point to the visitor's language when that version is live. An item's **Link Options** have a label per language, and for a link that isn't a page its URL per language. Without one, the item keeps its own.
