---
id: 01m5x9ea75bkfh9a0v0gsww8g7
title: Components
position: 3
description: Design something once, like a header, a card or a whole page, and reuse it everywhere. A synced one updates everywhere; one that isn't is a copy to change freely.
---
A component is a piece of design you make once and use in many places: a header, a footer, a card, a hero, a whole about page. A component is either synced or not:

- **Synced** (the default): every page that uses it stays linked to it. Edit the component, and every page changes with it. Use it for headers, footers and cards.
- **Not synced**: inserting it puts a copy of its blocks on your page, to change however you like. The component stays as it was, and nothing you change on the page reaches it. Use it for blocks to start from, like a hero with a photo, a row of three features, a team or a whole page.

![The Header component open in the editor, with its settings on the right.](/media/screens/design-component.webp)

Components live under **Components**, in **Structure**, each shown as your site draws it, grouped by category. Search finds a component by its name, category, description or keywords, and **Display** switches to a table, like the list of templates. Open one to edit it in the editor, like a page, and **Publish** it. **Synced**, in its settings, switches between the two kinds.

Categories are free words. These are offered first: **Heroes**, **Text**, **Media**, **Features**, **People**, **Lists**, **Calls to Action** and **Pages**. Any other category you type makes a new group.

## Make a component

1. Select the blocks you want to reuse, like a card or a section. To take several blocks side by side, click the first and `⇧`-click the last.
2. Choose **Make a Component** in the **⋯** menu at the top of the block's settings, or in the block's own **⋯** menu on the page.
3. Give it a **Name**, and optionally a **Category** and a **Description** that tell others when to use it.
4. Leave **Synced** on to replace the blocks you selected with the component, so this page updates with it too. Turn it off to save a copy to start from: the page keeps its blocks as they are.

Some blocks only accept certain blocks inside them. Where a synced component can't go, **Synced** isn't offered, and the blocks are saved as a copy. You can also make a component from scratch with **New Component** in **Components**.

## Insert a component

Press the `+` between two blocks, or the `+` at the top of the editor, and open the **Components** tab. Components are shown as pictures, by category. Click one: a synced component is placed as itself, and one that isn't puts a copy of its blocks where you are. Search, or `/` in an empty line, lists matching components with the blocks, under **Components**.

A component that isn't synced can only go where all of its blocks are allowed. Where it can't, it isn't offered.

## Start a page from a component

A new, empty page offers **Start From a Component** next to **Write, or press “/” for blocks**. It lists the components in the category **Pages** that aren't synced, as pictures. Choose one and the page starts with a copy of it. Or don't: a page starts blank otherwise.

## Give each copy its own content

Properties belong to a synced component: a copy of one that isn't synced is ordinary blocks, and has none.

A card component is more useful when each copy can show its own title, image and link. Those are the component's **properties**.

1. Open the component: select a copy and press **Edit Component** (the pencil) in its **Content** tab, or open it from **Structure → Components** in the sidebar.
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

Components are entries of the `components` collection, one Markdown file each in `content/collections/components/<handle>.md`. The settings are in the front matter (`synced`, `category`, `description`, `keywords`, `props`) and the body is the blocks, in [Block Markdown](/reference/block-markdown). `synced: false` makes a component a copy to start from; left out, it is synced:

```markdown
---
id: 01m7b9q2yk5r3s1a4t6w8x0zcb
title: Hero With Photo
status: published
synced: false
category: Heroes
description: A photograph filling the screen, with a headline and a button.
keywords: [intro, cover]
---

::: section {"props":{"width":"wide","background_image":["01m7b9q2yk5r3s1a4t6w8x0zcc"],"overlay":"dark"}}
# Eleven kilometres of coast

:::: buttons
::::: button {"props":{"label":"Walk with us","url":"/walks","variant":"primary"}}
:::::
::::
:::
```

Lettern writes the `id` and `status`. A file in a [site package](/design/sites) may leave them out. A site carries its components when it is applied, in `design` mode too, and when it is exported. One whose name the site already has follows the same `clash` choice as templates.

### Components from a plugin

A plugin ships read-only components with the `blocks.component-sources` filter: folders of `<handle>.md` files in the same form, or `<handle>.json` files with `title`, `synced`, `category`, `description`, `keywords`, `props` and `blocks`. They are listed and inserted like the site's own, marked as coming from a plugin:

```php
$this->cms()->hooks()->addFilter('blocks.component-sources', fn (array $sources) => [
    ...$sources,
    ['path' => $this->path('components'), 'source' => 'acme/reviews'],
]);
```

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

A copy of a synced component on a page is a `component` block. Its `props.values` holds the values set for this copy, and `bind` with `values.<handle>` takes a value from data:

```json
{ "type": "component", "props": { "ref": "card", "values": { "link": "/pricing" } }, "bind": { "values.title": "item.title", "values.image": "item.cover" } }
```

Text edited on the page is stored in the instance's `props.values`. Inline editing works for an exact `props.<handle>` text binding to a declared `text`, `textarea` or `richtext` property; editing an inherited default creates an override. A nested component can forward such a property with an exact binding like `"values.heading": "props.title"`, as long as each property it passes through has one of those types; the edit still belongs to the outer instance. Data-bound properties, bindings with filters, placeholders or `|raw`, repeats, nested constants and sample content keep their source controls instead.

### Abilities

`components/list` returns every component with `synced`, its properties and its blocks, in category order (`working: true` includes drafts, `category: "Pages"` only that category, `synced: false` only the copies to start from). `components/save` creates or replaces one by handle, with `synced` and its blocks as a list of nodes or as Block Markdown. To insert a synced component, place a `component` block; to insert one that isn't, copy its `blocks` into the document. For anything else use the `entries/*` abilities in the `components` collection.
