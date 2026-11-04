---
id: 01m5wn8rabhjdafzhbyn4mynmk
title: Templates
position: 2
description: The frame around your pages, with the header, footer and layout, designed once and shared by every page that uses it.
---
A template is the frame around a page: the header at the top, the footer at the bottom, and the layout in between. Each page only holds its own content, and the template puts it in place. Change the template, and every page that uses it changes with it.

![The Page template open in the editor: the header and footer around the Page Content block.](/media/screens/template.webp)

Templates are made of blocks, just like pages, so you design them the same way.

## Edit a template

1. Open **Templates**, under **Design** in the sidebar, and choose one, like *Page*.
2. Edit it like any page: select blocks, style them, add new ones.
3. Press **Publish**. Every page that uses the template is rebuilt.

Your changes save as a draft while you work, and visitors only see them once you publish.

## The Page Content block

Every template has one **Page Content** block. It marks where each page's own blocks go. Style it like any other block, for example with a narrow width for articles.

Around it you can add anything: a heading, a cover image, a date. Connect those blocks to the page's own fields, and each page shows its own title or image there. See [Showing content](/design/data).

The header and footer are usually [components](/design/components), so every template shares the same ones.

## Choose a page's template

A page uses the first template it finds here:

1. The page's own **Template** setting, when its collection has one.
2. Its collection's **Template**, on the collection's **Settings** tab under **Collections**.
3. The template called *default*.

The **Template** picker's first option, **Default**, names the template a page gets when you haven't chosen one, like *Default (Page)*. Choose another template to override it; choose **Default** again to inherit. If a chosen template has been deleted, the picker says so and shows the one used instead.

A template's **Offered For** setting limits which collections can pick it. Leave it empty to offer it everywhere.

## Special templates

- *default* frames every page that has no other template.
- *404* shows pages that don't exist.
- *error* frames the short message a visitor gets after sending too many requests in a minute, like on a busy checkout form. Without it, *default* is used.

A site without any templates still works: pages show their content and nothing else until you add *default*.

::: callout {"props":{"tone":"tip","text":"Give the block around your content the anchor <code>main</code>, under <strong>Content → Advanced</strong>. Every page then gets a <strong>Skip to content</strong> link for keyboard users."}}
:::

## For developers

### Stored as files

Templates are entries of the `templates` collection, stored as Markdown files in `content/collections/templates/`, with their blocks as [Block Markdown](/reference/block-markdown). They are reviewed in pull requests with the rest of the site:

```markdown
---
id: 01m5x7tz3jgvbn7k9d02ce4m1r
title: Article
collections:
  - posts
---

::: pattern {"props":{"ref":"header"}}
:::

::: outlet {"props":{"wrap":true},"class":"cms-prose"}
:::
```

`collections` is **Offered For**. The **Page Content** block is `outlet`.

### A typical template

```json
[
  { "type": "pattern", "props": { "ref": "header" } },
  { "type": "box", "props": { "tag": "main" }, "anchor": "main", "children": [
    { "type": "heading", "props": { "level": "1" }, "bind": { "text": "entry.title" } },
    { "type": "outlet", "props": { "wrap": true }, "class": "cms-prose" }
  ] },
  { "type": "pattern", "props": { "ref": "footer" } }
]
```

### Choosing a template

- An entry's own choice comes from a field like `{ type: select, dynamic: templates }` in its collection.
- A collection names its template by slug: `template: post`.
- Otherwise the template with the slug `default` is used. Missing pages render `404`; rate-limited requests render inside `error`, or `default`.

### Abilities

`templates/list` returns every template with its blocks (`working: true` includes unpublished changes). Create and change them with `entries/create` and `entries/update` in the `templates` collection; the body field is `blocks`.
