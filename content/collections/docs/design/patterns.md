---
id: 01m7bds07tgxqd4hxte84f7g3d
title: Patterns
position: 4
description: Arrangements of blocks to start from, like a hero, a gallery or a whole page. Insert a copy and make it your own.
---
A pattern is an arrangement of blocks to start from: a hero with a photo, a row of three features, a team, a whole about page. Insert one and you get a copy on your page, to change however you like. The pattern itself stays as it was, and nothing you change on the page reaches it.

A pattern is never linked to the pages it was copied to, and it has no properties. When you want something that stays the same everywhere and changes everywhere at once, like a header or a card, make a [component](/design/components) instead.

## Find your patterns

Open **Patterns** in the sidebar's **Design** section. Every pattern is shown as your site draws it, grouped by category. Search finds a pattern by its name, category, description or keywords. Open one to edit it in the editor, like a page, and **Publish** it.

Categories are free words. These are offered first: **Heroes**, **Text**, **Media**, **Features**, **People**, **Lists**, **Calls to Action** and **Pages**. Any other category you type makes a new group.

## Insert a pattern

Press the `+` between two blocks, or the `+` at the top of the editor, and open the **Patterns** tab. Patterns are shown as pictures, by category. Click one to put a copy where you are. Search lists matching patterns with the blocks, under **Patterns**.

A pattern can only go where all of its blocks are allowed. Where it can't, it isn't offered.

## Start a page from a pattern

A new, empty page offers **Start From a Pattern** next to **Write, or press “/” for blocks**. It lists the patterns in the category **Pages**, as pictures. Choose one and the page starts with a copy of it. Or don't: a page starts blank otherwise.

## Save blocks as a pattern

1. Select the blocks you want to keep, like a section. To take several blocks side by side, click the first and `⇧`-click the last.
2. Choose **Save as Pattern** in the block's **⋯** menu on the page, or in the **⋯** menu at the top of its settings.
3. Give it a **Name**, and optionally a **Category** and a **Description** that tell others when to use it.

The page keeps its blocks as they are. You can also make a new pattern from scratch with **New Pattern** in **Patterns**.

## For developers

### Stored as files

Patterns are entries of the `patterns` collection, one Markdown file each in `content/collections/patterns/<handle>.md`. The front matter has the `title`, a `category`, a `description` and `keywords`. The body is the blocks, in [Block Markdown](/reference/block-markdown):

```markdown
---
id: 01m7b9q2yk5r3s1a4t6w8x0zcb
title: Hero With Photo
status: published
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

Lettern writes the `id` and `status`. A file in a [site package](/design/sites) may leave them out. A site carries its patterns when it is applied, in `design` mode too, and when it is exported. One whose name the site already has follows the same `clash` choice as templates and components.

### Abilities

`patterns/list` returns every pattern with its blocks, in category order (`working: true` includes drafts, `category: "Pages"` only those). `patterns/save` creates or replaces one by handle, with its blocks as a list of nodes or as Block Markdown. To insert a pattern, copy its `blocks` into a document. For anything else, use the `entries/*` abilities in the `patterns` collection.

### Patterns from a plugin

A plugin ships read-only patterns with the `blocks.pattern-sources` filter: folders of `<handle>.md` files in the same form, or `<handle>.json` files with `title`, `category`, `description`, `keywords` and `blocks`. They are listed and inserted like the site's own, marked as coming from a plugin, and can't be changed or saved over:

```php
$this->cms()->hooks()->addFilter('blocks.pattern-sources', fn (array $sources) => [
    ...$sources,
    ['path' => $this->path('patterns'), 'source' => 'acme/reviews'],
]);
```
