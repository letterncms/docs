---
id: 01m5wn8rabhjdafzhbyn4mynmk
title: Templates
position: 2
group: 'Foundations'
description: A template is the frame around a page — header, footer, layout and the fields shown around the content — edited as blocks like any page.
---
Open **Templates** in Settings. Each template is an entry of the `templates` collection and opens in the shared [block editor](/editing/writing). It holds blocks like a page does, plus one **Page content** block where each page's own blocks go.

A typical template:

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

- The header and footer are [components](/design/components), so every template shares them.
- Blocks around the content can show the page's own fields — the title, a date, a cover image — through [data binding](/design/data).
- Giving `main` the anchor `main` adds a **Skip to content** link to every page.

## Which template a page gets

1. The entry's own **Template** field, when its collection has one (`type: select`, `dynamic: templates`).
2. The collection's `template` setting — the template's slug, e.g. `template: post`.
3. The template called `default`.

Missing pages render the `404` template. A visitor who sends too many requests in a minute (a checkout form, say) gets a short message inside the `error` template, or `default` when there is none. A site without templates still works: pages show their content and nothing else until you add `default`.

A template's **Offered for** setting limits the collections whose entries can pick it; leave it empty to offer it everywhere.

The Template picker shows the actual inherited template name with an **Inherited** hint. An entry inherits its collection's template; collection settings inherit the site's default. Choosing a template creates an explicit override, and clearing it restores inheritance. If a saved override is missing, the picker identifies it and shows the effective fallback rather than silently replacing the saved value.

## Designing a template

Edit the template as live rendered blocks. Its **Page content** block marks where each entry body is rendered. The same template context and styles appear in the editor and public output; **Preview** checks interactions without editing controls. An article template sets a narrow reading width within this same editor.

Like any entry, a template saves a draft while you work and goes live when you **Publish** — and then every page using it is rebuilt.

## Stored as files

Templates are Markdown files with their blocks as [Block Markdown](/editing/block-markdown) in `content/collections/templates/`, so they are reviewed in pull requests with the rest of the site:

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

## For agents

`templates/list` returns every template with its blocks (`working: true` includes unpublished changes). Create and change them with `entries/create` and `entries/update` in the `templates` collection; the body field is `blocks`.
