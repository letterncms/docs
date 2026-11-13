---
id: 01m5x9ea75bkfh9a0v0gsww8g7
title: Components
position: 3
description: Design something once, like a header or a card, and reuse it everywhere. Change it once and every copy updates.
---
A component is a piece of design you make once and use in many places: a header, a footer, a card, a call to action. Edit the component, and every page that uses it changes with it.

![The Header component open in the editor, with its settings on the right.](/media/screens/design-component.webp)

Components live under **Components**, in the sidebar's **Design** section. Every copy stays linked to its component. Use them for headers, footers and cards. For blocks you want to copy once and then change freely, like a hero or a whole page to start from, use a [pattern](/design/patterns).

## Make a component

1. Select the block you want to reuse, like a card. To take several blocks side by side, click the first and `⇧`-click the last.
2. Choose **Make a Component** in the **⋯** menu at the top of the block's settings, or in the block's own **⋯** menu on the page.
3. Give it a **Name**, and optionally a **Category** and a **Description** that tell others when to use it.

A component replaces the blocks you selected, so this page updates with it too.

Some blocks only accept certain blocks inside them. Where a component can't go, **Make a Component** isn't offered. **Save as Pattern** keeps a copy of the blocks instead.

## Insert a component

Press the `+` between two blocks, or type `/` in an empty line, and search. Components are listed with the blocks, under **Components**.

## Give each copy its own content

A card component is more useful when each copy can show its own title, image and link. Those are the component's **properties**.

1. Open the component: select a copy and press **Edit Component** (the pencil) in its **Content** tab, or open it from **Components** in the sidebar.
2. In the component's settings, under **Properties**, press **Add Property**. Choose a type, like text, image or link, and give it a label. It works like adding a field to a collection.
3. Select the block inside the component that should show it, like the card's heading. Point at its **Text**, press the database icon beside the label (**Connect to Data**), and pick the property under **Component Properties**.
4. **Publish** the component.

Now select a copy on any page. Its **Content** tab lists the properties: fill in each one for this copy. Text properties can also be edited right on the page, by clicking the text and typing. Your change only affects this copy, never the component or its other copies.

Each property can come from data too. Point at it and press the database icon beside its label: a card inside a [Repeat](/design/data#show-a-list-with-repeat) can take its title from each blog post.

## Change a component

- To change every copy, press **Edit Component** and edit it like a page. **Publish** it, and every page that uses it is rebuilt.
- To make this copy different from the rest, press **Detach** (the scissors) in its **Content** tab. The copy becomes ordinary blocks you can edit freely, and no longer follows the component.

Pages always show a component's published version. The editor and preview show your latest changes.

::: callout {"props":{"tone":"tip","text":"A copy has no <strong>Design</strong> settings of its own: the design belongs to the component. Edit the component to change it everywhere."}}
:::

## For developers

### Stored as files

Components are entries of the `components` collection, stored as Markdown files in `content/collections/components/`. The settings are in the frontmatter (`category`, `description`, `props`) and the blocks are [Block Markdown](/reference/block-markdown).

Plugins can ship read-only components too, with the `blocks.component-sources` filter and folders of `<handle>.json`.

### Properties

`props` is a list of fields, like a collection's. Inside the component, blocks [bind](/design/data) to them as `props.<handle>`:

```yaml
props:
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

### Instances

A copy on a page is a `component` block. Its `props.values` holds the values set for this copy, and `bind` with `values.<handle>` takes a value from data:

```json
{ "type": "component", "props": { "ref": "card", "values": { "link": "/pricing" } }, "bind": { "values.title": "item.title", "values.image": "item.cover" } }
```

Text edited on the page is stored in the instance's `props.values`. Inline editing works for an exact `props.<handle>` text binding to a declared `text`, `textarea` or `richtext` property; editing an inherited default creates an override. A nested component can forward such a property with an exact binding like `"values.heading": "props.title"`, as long as each property it passes through has one of those types; the edit still belongs to the outer instance. Data-bound properties, bindings with filters, placeholders or `|raw`, repeats, nested constants and sample content keep their source controls instead.

### Abilities

`components/list` returns every component with its properties and blocks (`working: true` includes drafts). `components/save` creates or replaces one by handle; for anything else use the `entries/*` abilities in the `components` collection.
