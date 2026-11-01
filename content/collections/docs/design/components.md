---
id: 01m5x9ea75bkfh9a0v0gsww8g7
title: Components
position: 3
group: 'Foundations'
description: Design something once — a header, a card, a pricing table — and reuse it everywhere. Properties let each copy show its own title, image or link.
---
Components are entries of the `components` collection. Open **Components** in Settings; each opens in the shared [block editor](/editing/writing). There are two kinds:

- **Synced components** (the default) are inserted as a reference. Change the component and every page that uses it changes — headers, footers, cards, calls to action.
- **Sections** (synced off) are copied into the page when inserted, then edited freely. Use them as a library of starting points.

For how editors insert, make and detach components, see [Components and sections](/editing/components).

## Properties

A component's **Properties** are fields — like a collection's — that every instance fills in. Inside the component, blocks [bind](/design/data) to them as `props.<handle>`:

```yaml
# The component's Properties setting
- handle: title
  type: text
  label: Title
  default: Fast by default
- handle: image
  type: media
  label: Image
  max: 1
- handle: link
  type: url
  label: Link
```

```json
{ "type": "box", "bind": { "link": "props.link" }, "children": [
  { "type": "image", "bind": { "image": "props.image", "visible": "props.image" } },
  { "type": "heading", "props": { "level": "3" }, "bind": { "text": "props.title" } }
] }
```

Select an instance on a page and its properties appear under **Content**. Each value can also come from data — inside a [Repeat](/design/data#repeat), a card component can take its title from each entry:

```json
{ "type": "pattern", "props": { "ref": "card", "values": { "link": "/pricing" } }, "bind": { "values.title": "item.title", "values.image": "item.cover" } }
```

An exact `props.<handle>` text binding to a declared `text`, `textarea` or `richtext` property can be edited inline as plain text, matching the server's escaped binding output. Editing an inherited default creates an override in that instance's `props.values`; the shared component stays unchanged. The Content inspector edits the same value.

Nested components can forward an editable property with an exact binding such as `"values.heading": "props.title"`, provided each forwarded property has an eligible declared text type. The edit still belongs to the original instance. Data-bound properties, filtered, interpolated or raw bindings, repeats, nested constants and sample content retain their source controls instead of exposing arbitrary generated text as editable content.

## Publishing

Components save drafts and publish like any entry. Pages always show a component's published version; the editor and preview use your working copy. Publishing a component rebuilds exactly the pages that use it.

## Stored as files

Components are Markdown files in `content/collections/components/`, with the settings in the frontmatter and the blocks as [Block Markdown](/editing/block-markdown). Plugins can ship read-only patterns too (the `blocks.pattern-sources` filter, folders of `<handle>.json`).

## For agents

`patterns/list` returns every component and section with its properties and blocks (`working: true` includes drafts). `patterns/save` creates or replaces one by handle; for anything else use the `entries/*` abilities in the `components` collection.
