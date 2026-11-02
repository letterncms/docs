---
id: 01m5wn8r9v75s4xsvb2gdk2g2j
title: Blocks
position: 2
template: reference-blocks
description: Every block on this site, with its settings and the style groups it supports, generated from the running CMS.
---
Every block you can add to a page, template or component is listed below, with its settings. Core blocks come from the blocks plugin; other plugins, such as forms, add their own.

A few primitives compose anything: **Box** (any HTML tag: a stack, a grid, a link, a button), **Text** and **Heading**, **Link**, **Button**, **Image**, **Icon** (1,500+ Phosphor icons), **Input**, **Repeat** and **Page content**. The rest, like sections, columns, cards, quotes, code, tables and accordions, are in the same block catalog, in every collection.

A block in [Block Markdown](/reference/block-markdown) and the API is `{type, props, style, attrs, bind, logic, motion, children, label}`: settings in `props`, CSS in `style` ([Styles](/design/styles)), extra attributes in `attrs` (a `style` attribute only sets CSS variables, such as `--color-primary` for one section), data connections in `bind` ([Showing content](/design/data)), scripts in `logic` ([Interactions](/design/interactions)) and animations in `motion` ([Animations](/design/animations)). Every block accepts every style section unless it says otherwise.

A **Table** can head its rows with its first column and mark one column with **Highlight Column**. **Look** switches between plain lines and a soft look without rules: the marked column fills with your primary color, and on a phone a table of up to four columns stacks each row's heading above its values.

An **Accordion** has a **Look** too: lines, or cards with each question on a soft panel of its own.
