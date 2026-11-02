---
id: 01m5wmrf54ajwj8th7vqpcrx9g
title: Navigation
position: 4
description: Build your site's menus from pages and links, with drag and drop. Links to pages keep working when pages move.
---
Menus are the lists of links in your header, your footer or anywhere else. Build them from your own pages and any other links, and drag them into order.

![The main menu, with its links in order.](/media/screens/content-menu.webp)

## Make a menu

1. Open **Settings → Navigation** and press **New Menu**.
2. Give it a name, like *Main*, *Footer* or *Legal*, and press **Create**.
3. Press **Add Page** to pick one of your pages, or **Add Link** for any other address.
4. Press **Save**.

## Pages and links

A **page** in a menu follows that page. Rename it or move it, and the menu keeps pointing to the right place. While the page isn't published, it stays out of the menu on your site; the editor marks it **Hidden until live**.

A page item shows the page's title unless you type a label of your own.

A **link** can go anywhere: a full address like `https://…`, a path on your site like `/contact`, a section of a page like `#menu`, an email address with `mailto:`, or a phone number with `tel:`. Click a link's settings button to open its **Link Options**, where you set the **Link** and can choose **Open in a New Tab**.

## Order and nest

Drag items up and down to reorder them, and sideways to nest one under another, for a dropdown. The buttons on each item do the same: **Nest Under the Item Above** and **Move Out a Level**.

**Levels** at the bottom sets how deep the menu may go, from 1 to 5.

## Show a menu on your site

A menu appears wherever a **Repeat** block lists it, usually in your header and footer. The starter site's header already shows the menu called *Main*, and its footer the one called *Footer*, so a new item appears there as soon as you save. See [Showing content](/design/data) to show a menu somewhere else.

The link to the page a visitor is on is marked for screen readers, and you can style it with the **Active** state.

## Menus in other languages

On a site with several [languages](/content/languages), page items lead to the visitor's language once that version is live. Each item's **Link Options** have a label for every other language, and a link has its address per language too. Leave one empty and the item uses its own.

## Delete a menu

Open the menu and press **Delete**. Repeat blocks that list it will show nothing, so take it out of your templates too.

## For developers

### The menu file

Menus are saved as YAML in `content/navigation/<handle>.yaml`. A page item stores the entry's id, a link its URL:

```yaml
title: Main
max_depth: 3
items:
  - { id: a1b2c3d4, entry: 01m6zz00000000000000000001 }
  - id: e5f6g7h8
    url: /contact
    label: Contact
    new_tab: true
    locales:
      de: { label: Kontakt, url: /de/kontakt }
```

### Showing a menu

Show a menu with a **Repeat** whose list is the menu, and a **Link** inside bound to each item:

```json
{ "type": "repeat", "props": { "source": "menu", "menu": "main", "tag": "ul" }, "children": [
  { "type": "box", "props": { "tag": "li" }, "children": [
    { "type": "link", "bind": { "label": "item.label", "url": "item.url", "state:active": "item.active" } }
  ] }
] }
```

Each item has `label`, `url`, `newTab`, `current` (this page), `active` (this page or one of its descendants) and `children` for the next level. Nest a Repeat with `source: list` and `path: item.children` for dropdowns. Style the active link with the `is-active` state. Links to the current page get `aria-current="page"` automatically.

### In PHP

`cms_menu('main')` returns the same list, or `null` when the menu doesn't exist.
