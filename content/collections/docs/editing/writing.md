---
id: 01m5wn8ra1rb2z4svj7jc29mr5
title: Writing
position: 0
group: 'In the editor'
description: Edit text and insert blocks directly in the rendered page, with the same model and controls for pages, posts and reusable layouts.
---
Pages, posts, docs, templates and components share one live block editor. Edit text directly in the rendered content, use the full block catalog for structure and layout, and open the [shared inspector](/editing/canvas) for Content, Design and Interact. The collection's explicit `body` field supplies the block content; collections without a body use the normal field form.

## Adding blocks

Rest the pointer between two blocks: a line marks the boundary and a `+` appears in its middle. The `+` opens the quick inserter: search, the six blocks you are most likely to want there, and **Browse all** for the full catalog with components and sections. The line stays on its boundary while you choose, and the new block lands exactly there. At the inner edge of a section or column the line hugs the first or last block inside it, so you can add content inside a container as well as between containers.

Clicking never adds content: it places the caret in text or selects a block. To insert next to a selected block, use **Insert before** or **Insert after** in its **⋯** menu (`⌥⌘T` / `⌥⌘Y`); an empty container shows its own `+` when you point at it, and an empty page offers to start writing. The toolbar's **Insert block** uses the same choices. Press `/` in an empty text block to insert while writing: the menu opens below the line, or above it near the bottom of the screen, so what you type stays visible. Keep typing to filter, press `Enter` to insert, and `Esc` or a click elsewhere to close it. Start a paragraph with a Markdown shortcut and it turns into the right block:

| Type | To get |
|---|---|
| `#` to `####` then space | Heading level 1–4 |
| `-` or `*` then space | Bulleted list |
| `1.` then space | Numbered list |
| `>` then space | Quote |
| ```` ``` ```` | Code block |
| `---` | Divider |

Pasting Markdown or HTML from elsewhere becomes blocks too.

Click rendered text to place the caret and write. Newly inserted text blocks focus their text directly. Text focus keeps block frames and structural controls out of the way, while an open sidebar shows that block's settings; press `Esc` to select the block when you want to move it or open its settings. An empty paragraph shows its hint only while you write in it; pointing at a block outlines it, so empty lines stay easy to find.

## Formatting

Select text for the format toolbar, or use the keyboard:

| Keys | Does |
|---|---|
| `⌘B` / `⌘I` / `⌘U` | Bold, italic, underline |
| `⌘⇧X` | Strikethrough |
| `⌘E` | Inline code |
| `⌘K` | Link |

## Moving around

| Keys | Does |
|---|---|
| `↑` `↓` at the edge of a block | Move to the previous or next block |
| `Esc` | Select the current block |
| `↑` `↓` on a selected block | Select the previous or next block |
| `↵` on a selected block | Write in its first text |
| `⇧↑` `⇧↓` on a selected block | Extend the selection over neighboring blocks |
| `⇧`-click a block | Extend the selection to it |
| `⌥↑` `⌥↓` on a selected block | Move it up or down |
| `⌘D` | Duplicate the selected block |
| `⌥⌘T` `⌥⌘Y` | Insert before or after the selected block |
| `⌘C` `⌘X` `⌘V` on selected blocks | Copy, cut and paste whole blocks |
| `⌫` on selected blocks | Delete them |

Selected blocks can be saved as a [component or section](/editing/components) with **Make a Component** in the block menu or the inspector.

Click a block (anywhere that isn't text) to select it; click outside the page content to clear the selection. A selected block has one toolbar above it: the drag handle on the left, select its parent, its name, **Move up** and **Move down** (disabled at either end), and **⋯** with **Insert before**, **Insert after**, **Duplicate**, **Make a Component** and **Delete**. You can also move blocks in Outline. During a drag, a line marks the compatible destination, including positions inside sections and columns, and the viewport scrolls near an edge. Press `Esc` or release outside a valid target to cancel. Movement participates in undo and redo.

The toolbar stays at the top of the view while a tall block is partly scrolled away, and disappears when the block leaves view.

## Entry details and block settings

The right sidebar starts with the entry's details tab, named after its collection type, followed by **History** and available plugin panels. Edit the title, author, URL slug or handle and other collection fields there. A template's exact entry-title text binding also lets you edit the same title inline; sample titles in templates and components stay read-only. See [Entry details](/content/entries#entry-details).

Use a block's settings to open its shared **Design**, **Content** and **Interact** controls. The same layout, data and motion tools are available for article blocks and page blocks. The live editing surface already uses the site renderer; **Preview** checks page interactions without editing controls.
