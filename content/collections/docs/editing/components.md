---
id: 01m5wn8r9yyjj5bvvq0etmgmkz
title: Components and sections
position: 2
group: 'In the editor'
description: Insert a header, a card or a call to action that stays in sync everywhere — or copy a ready-made section and make it your own.
---
**Components** are reusable designs that stay in sync: change the component and every page that uses it changes. **Sections** are starting points copied into the page when inserted. Both live in the **Components** collection — see [Components](/design/components) for building them with properties.

## Inserting

Press `/` or open **Insert block**. Components and sections are listed alongside the available blocks; choose one to insert it into the document.

A component instance shows its **properties** under **Content** — a card's title, image and link. Fill them in, or connect them to data with the database icon.

When rendered text uses a declared local text property, you can edit it inline as plain text too. It changes the selected instance's property, using the same value as **Content**; editing a default creates a local override. A nested component can forward that property and keep the same editable value. The shared component and its other instances keep their values. Text supplied by data, repetition or more complex bindings stays controlled through its source settings.

## Making a component

Select the blocks you want to reuse — click one, `⇧`-click a neighbor to extend — and press the diamond in the inspector (or **Make a component…** with several blocks selected). Give it a name, a category and a description.

- With **Component** on, the selected blocks are replaced by the new component, so this page updates with it too.
- With it off, it is saved as a section and the page keeps its own copy.

Where a component is not allowed (inside a block that only accepts certain children), it is saved as a section.

## Editing and detaching

- **Edit component** (under **Content**) opens the component. Publish it to update every page.
- **Detach** replaces the instance with a copy of its blocks, so this page can differ.

## Why they matter

Components keep sites consistent — whoever builds the next page, person or agent. Agents read them with `patterns/list` and use them first.
