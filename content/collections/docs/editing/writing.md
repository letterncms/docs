---
id: 01m5wn8ra1rb2z4svj7jc29mr5
title: Writing
position: 0
description: Type, add blocks, move them around and format text, right on the page.
---
You write and build pages right on the page itself, exactly as visitors will see it. Click to type, press `+` to add something, and select a block to move or style it.

![The page editor: the page on the left, the settings of the selected heading on the right.](/media/screens/editor.webp)

Everything on a page is a **block**: a heading, a paragraph, an image, a button, a row of columns. The same editor works for pages, posts, templates and components.

## Type

Click any text and start typing. Press `↵` for a new paragraph, or `⇧↵` for a line break inside the same one.

While you type, block outlines and toolbars stay out of the way. Changes save as you go, and nobody sees them until you press **Publish**.

## Add a block

1. Point between two blocks. A line appears there, with a `+` in the middle.
2. Press the `+`. A small menu opens with a search field, six suggestions (the blocks you used last come first) and **Browse All** for every block, component and section.
3. Pick one. It lands exactly on the line.

The line also works inside sections and columns: point near their inner edge to add something inside them.

::: callout {"props":{"tone":"tip","text":"Faster while writing: in an empty line, type <code>/</code> and the name of a block, like <code>/image</code>, then press <code>Enter</code>. <code>Esc</code> closes the menu."}}
:::

A few other ways to add a block:

- **Insert Before** or **Insert After** in a selected block's **⋯** menu.
- The `+` an empty section or column shows when you point at it.
- An empty page invites you to start writing, or to press `/` for blocks.
- **Insert block**, the `+` in the toolbar at the top. On a phone, the canvas has its own.

Clicking on the page never adds anything by accident: it only places the caret or selects a block.

### Markdown shortcuts

Start a new line with one of these and it turns into the right block. Pasting Markdown or HTML from elsewhere becomes blocks too.

| Type | To get |
|---|---|
| `#` to `####`, then a space | A heading, level 1 to 4 |
| `-` or `*`, then a space | A bulleted list |
| `1.`, then a space | A numbered list |
| `>`, then a space | A quote |
| `!`, then a space | A callout |
| ```` ``` ```` | A code block |
| `---` | A divider |

## Select and move blocks

Click a block anywhere that isn't text to select it. While you're typing, press `Esc` to select the block you're in. Click outside the page to clear the selection.

A selected block gets a small toolbar above it, with:

- the **drag handle**, to drag the block somewhere else,
- an arrow to select the block it sits in,
- the block's name,
- **Move Up** and **Move Down**,
- **⋯** for **Insert Before**, **Insert After**, **Duplicate**, **Make a Component** and **Delete**.

While you drag, a line shows where the block will land, and the page scrolls when you near an edge. Press `Esc`, or let go somewhere it can't go, to cancel.

`⇧`-click a neighboring block to select the run of blocks between them. Hard-to-reach blocks, including hidden ones, are easiest to pick in the **Outline**: while you edit, it takes the place of the sidebar on the left (`⌘\` shows or hides it). Made a mistake? `⌘Z` undoes it, moves included.

To reuse a selection elsewhere, choose **Make a Component**. See [Components](/design/components).

## Format text

Select some text and a format toolbar appears above it: bold, italic, underline, strikethrough, code and link. The shortcuts are below.

## Style a block

Selecting a block also opens its settings on the right, in three tabs: **Content**, **Design** and **Interact**. See [Block settings](/editing/canvas).

## Page details

The right sidebar starts with the page's own details, in a tab named after its collection (**Page**, **Survey**…); the toolbar button that opens it is **Page Details**. Edit the title, URL, author and other fields there. Next to it are **History** and the tabs plugins add, like **Comments**. Press `⌘.` to show or hide it. See [Entries](/content/entries).

## Keyboard shortcuts

On Windows and Linux, use `Ctrl` for `⌘` and `Alt` for `⌥`. Press `?` anywhere in the admin to see the keys that work on the screen you are on; the list is also in the command palette.

### Formatting

| Keys | Does |
|---|---|
| `⌘B` / `⌘I` / `⌘U` | Bold, italic, underline |
| `⌘⇧X` | Strikethrough |
| `⌘E` | Inline code |
| `⌘K` | Link |

### Blocks

| Keys | Does |
|---|---|
| `↑` `↓` at the edge of a block | Move to the previous or next block |
| `Esc` | Select the block you're typing in |
| `↑` `↓` on a selected block | Select the previous or next block |
| `↵` on a selected block | Write in its first text |
| `⇧↑` `⇧↓` on a selected block | Extend the selection over neighboring blocks |
| `⇧`-click a neighboring block | Extend the selection to it |
| `⌥↑` `⌥↓` on a selected block | Move it up or down |
| `⌘D` | Duplicate the selected block |
| `⌥⌘T` / `⌥⌘Y` | Insert before or after the selected block |
| `⌘C` `⌘X` `⌘V` on selected blocks | Copy, cut and paste whole blocks |
| `⌫` on selected blocks | Delete them |
| `⌘Z` / `⌘⇧Z` | Undo, redo |

### The page

| Keys | Does |
|---|---|
| `⌘S` | Save now |
| `⌘⇧P` | Publish |
| `⌘.` | Show or hide the sidebar |

## For developers

### Which collections use this editor

A collection gets the block editor when its `body` names a field of type `blocks`, like `body: content` for Pages: that field holds the page's blocks. A collection without a body shows its fields as a normal form instead. See [Collections](/content/collections).

### Titles in templates

When a template binds a text block to exactly the entry's title, you can edit the title inline on the page too. Sample titles in templates and components stay read-only.
