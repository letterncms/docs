---
id: 01m5wn8r9jwsewrfveme7cp117
title: Block Markdown
position: 6
group: 'Reference'
description: A plain-text form of any block tree — Markdown for text, directives for everything else. Used for files, agents and AI crawlers.
---
Text blocks are written as ordinary Markdown. Every other block becomes a **directive**: three colons, the block type and its settings as JSON, its children inside, and three colons to close. Nested directives use one more colon per level.

```markdown
## Plans for every team

Start small, grow when you need to.

::: section {"props":{"width":"wide"},"style":{"base":{"paddingBlock":"token:space.16"}}}
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

- **Flat-file entries** store block fields as Block Markdown, so pages — and [templates](/design/templates) and [components](/design/components) — diff cleanly in git.
- **Agents** can write a blocks field as a Block Markdown string instead of JSON — often shorter and easier to get right.
- **Markdown twins**: every published page is also available as `/page.md`, a clean Markdown version for AI crawlers and tools.
- **Conversion** abilities: `blocks/from-markdown` and `blocks/to-markdown`.

Everything on a block survives a round trip — ids, names, styles, attributes, data bindings, interactions, animations, anchors and hidden flags — so converting back and forth never loses design:

```markdown
::: heading {"props":{"level":"1"},"bind":{"text":"entry.title"},"motion":[{"id":"m1","trigger":{"type":"load"},"steps":[{"target":"words","from":{"opacity":0,"y":24}}]}]}
:::
```

A text block stays plain Markdown only while Markdown says everything about it. A `tag`, an anchor, a style or an id something points at keeps it a directive. Blocks written without an id get one when the page is read, the same one every time, and a save leaves it out again unless something points at it, so hand-written Markdown stays as you wrote it.
