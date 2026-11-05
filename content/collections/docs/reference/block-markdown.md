---
id: 01m5wn8r9jwsewrfveme7cp117
title: Block Markdown
position: 3
description: Any page as plain text, with Markdown for the text and directives for every other block. Used in files, by AI agents and for AI crawlers.
---
Block Markdown is a way to write any page, template or component as plain text. Text blocks are ordinary Markdown. Every other block becomes a **directive**: three colons, the block type and its settings as JSON, its children inside, and three colons to close. Nested directives use one more colon per level.

```markdown
## Plans for every team

Start small, grow when you need to.

::: section {"props":{"width":"wide"},"style":{"base":{"paddingBlock":"3xl"}}}
:::: columns {"props":{"layout":"1-1"}}
::::: column
### Starter

For a single site.
:::::
::::: column
### Agency

For all your clients.
:::::
::::
:::
```

## Where it is used

- **Flat-file entries** store block fields as Block Markdown, so pages, [templates](/design/templates) and [components](/design/components) diff cleanly in git.
- **Agents** can write a blocks field as a Block Markdown string instead of JSON. It's often shorter and easier to get right.
- **Markdown twins**: every published page is also available as `/page.md`, a clean Markdown version for AI crawlers and tools.
- **Conversion** abilities: `blocks/from-markdown` and `blocks/to-markdown`.

## Round trips

Everything on a block survives a round trip, so converting back and forth never loses design: ids, names, styles, attributes, data bindings, interactions, animations, anchors and hidden flags. Here is a heading bound to the entry's title, with an animation:

```markdown
::: heading {"props":{"level":"1"},"bind":{"text":"entry.title"},"motion":[{"id":"m1","trigger":{"type":"load"},"steps":[{"target":"words","from":{"opacity":"0","y":"lg"},"duration":"slower","ease":"out"}]}]}
:::
```

A directive's `style` holds names of the [design system](/design/design-system), never CSS values. Base properties can sit at the top, beside conditions like `max-md` (phones), `max-lg` (tablets and phones) or `hover`:

```markdown
::: heading {"props":{"level":"2"},"style":{"text":"heading-2","color":"foreground-muted","paddingBlock":"section","max-md":{"text":"heading-3"}}}
:::
```

A value outside the vocabulary is left out. See [Styles](/design/styles#for-developers).

A text block stays plain Markdown only while Markdown says everything about it. A `tag`, an anchor, a style or an id something points at keeps it a directive. Blocks written without an id get one when the page is read, the same one every time, and a save leaves it out again unless something points at it, so hand-written Markdown stays as you wrote it.
