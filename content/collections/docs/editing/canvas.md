---
id: 01m5wn8r9r15yvxknmkg7x1nfh
title: Block settings
position: 1
group: 'In the editor'
description: The shared Content, Design and Interact inspector for every block, with live site rendering and inline block editing.
---
Pages, posts, templates and components use one live block editor. The surface uses Lettern's site renderer, so authored content, styles, bindings and layout stay visible while you work. Edit text inline, insert any compatible block and use the shared inspector for content, design and interactions.

## The workspace

- **Live content** — rendered blocks in their real layout. An article follows its narrow template; a landing page keeps its designed composition. Click text to write without a selection frame; click anywhere else in a block to select it. Pointing at a block outlines it. Clicking never adds content.
- **Insertion** — rest the pointer between blocks for a boundary line with a `+`, which opens the quick inserter (search, suggestions and **Browse all**). The line stays on its boundary while you choose. **Insert before/after** in a block's menu, an empty container's `+` and **Insert block** in the toolbar use the same catalog and structural rules. See [Writing](/editing/writing#adding-blocks).
- **Block toolbar** — a selected block gets one toolbar above it: the drag handle, select parent, the block's name, **Move up** and **Move down**, and a **⋯** menu (insert before or after, duplicate, make a component, delete). Its settings open in the sidebar. Press `Esc` or drop outside a valid target to cancel a drag. The same validation and undo rules apply to every way of moving. The toolbar stays in view while a tall block scrolls and leaves with the block.
- **Outline** — navigate the nested structure and select blocks that are difficult to reach on the page, including hidden or bound content.
- **Right sidebar** — entry details, **History** and plugin tabs. Selecting a block opens its shared inspector, and writing in a block shows its inspector while the sidebar is open; the entry-name button returns to record details.

## Content, Design, Interact

- **Content** edits a block's settings or connects them to data with the database icon. Visibility, anchors, classes and attributes use the same panel. See [Data and Repeat](/design/data).
- **Design** edits CSS: layout, position, size, spacing, typography, fill, border, effects, transform and transition. Choose the screen size and state to edit responsive or hover/focus variants. See [Styles](/design/styles).
- **Interact** adds [animations](/design/animations) and [interactions](/design/interactions).

Text option groups use the inspector's width and wrap in narrower panels. Use `Tab` to focus an option group and the arrow keys to choose an option. All collections share these controls and the same block catalog.

## Checking interactions

The editor already shows live rendering. The entry toolbar's **Preview** opens the current working content and page interactions without editing affordances. It includes unsaved title, content, URL and author changes, and is available before the first save. Return to the same surface to keep editing; there is no separate writing mode or second content model.

## Saving and publishing

The shared editor saves a working copy as you type. **Publish** in the top bar makes the reviewed version public. Templates and components use the same lifecycle; publishing a shared source rebuilds pages that depend on it. See [Entries](/content/entries).
