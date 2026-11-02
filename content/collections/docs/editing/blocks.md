---
id: 01m5wn8r9v75s4xsvb2gdk2g2j
title: Blocks reference
position: 5
group: 'Reference'
template: reference-blocks
description: Every block available on this installation, with its props and the style groups it supports. Generated from the running CMS.
---
Core blocks come from the blocks plugin; plugins (such as forms) add their own. A few primitives compose anything: **Box** (any HTML tag — a stack, a grid, a link, a button), **Text** and **Heading**, **Link**, **Button**, **Image**, **Icon** (1,500+ Phosphor icons), **Input**, **Repeat** and **Page content**. The rest — sections, columns, cards, quotes, code, tables, accordions — are available in the same block catalog, in every collection.

A block in [Block Markdown](/editing/block-markdown) and the API is `{type, props, style, attrs, bind, logic, motion, children, label}`: settings in `props`, CSS in `style` ([Styles](/design/styles)), extra attributes in `attrs` (a `style` attribute only sets CSS variables, such as `--color-primary` for one section), data connections in `bind` ([Data and Repeat](/design/data)), scripts in `logic` ([Interactions](/design/interactions)) and animations in `motion` ([Animations](/design/animations)). Every block accepts every style section unless it says otherwise.

A **Table** can head its rows with its first column and mark one column with **Highlight Column**. **Look** switches between plain lines and a soft look without rules: the marked column fills with your primary color, and on a phone a table of up to four columns stacks each row's heading above its values.

An **Accordion** has a **Look** too: lines, or cards with each question on a soft panel of its own.
