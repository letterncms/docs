---
id: 01m5wn8r9r15yvxknmkg7x1nfh
title: Block settings
position: 1
description: Select any block to change what it says, how it looks and how it moves.
---
Select any block and its settings open in the sidebar on the right, in three tabs: **Content** for what it says, **Design** for how it looks, and **Interact** for how it moves. Every block has the same three tabs, on every page, template and component.

![A heading selected on the home page, with its Design settings open on the right.](/media/screens/editor.webp)

The page you edit is the real site, drawn by the same engine that builds it for visitors. What you see while you work is what they get.

## Open a block's settings

1. Click a block anywhere that isn't text. Or, while typing in it, press `Esc`.
2. Its settings open on the right, under its name.
3. Pick **Content**, **Design** or **Interact**.

If the sidebar is closed, press `⌘.` to open it. To get back to the page's own details, press the back button at the top of the sidebar, named after the collection (**Page**, **Dish**…).

To rename the block, double-click its name, or choose **Rename** in its **⋯** menu, beside the name. The same menu has **Duplicate**, **Make a Component** and **Delete**.

## Content

Change what the block says or shows, like a heading's level or a button's link. Then, further down:

- **Visibility** hides a block on the site, or shows it only when some data says so.
- **Advanced** holds the technical settings: the HTML tag, a button's type, how an image loads (**Load First**, **Shown Width**), and a **Layer Name**, an **Anchor** to link to (`#menu`), extra CSS **Classes** and HTML **Attributes**.

Point at a setting and a database icon appears beside its label, **Connect to Data**: the setting then comes from your content instead of being typed in, like a dish's price or the latest posts. See [Showing content](/design/data).

## Design

Change how the block looks, section by section: **Layout**, **Position**, **Size**, **Spacing**, **Typography**, **Color**, **Border**, **Effects**, **Transform** and **Transition**.

Every value is a name from your [design system](/design/design-system), like a text style, a color of your scheme or a spacing step, so the block keeps matching the rest of the site when those change.

### Different screens and states

Switch between **Desktop**, **Tablet** and **Phone** in the editor's top bar, with or without a block selected. **Desktop** always shows the desktop layout, scaled down when the window has less room. A change made for **Tablet** applies to tablets and phones, one for **Phone** only to phones; a line at the top of the **Design** tab says so, with **Back to Desktop**.

The states at the top of the **Design** tab pick what you're styling: **Default**, **Hover**, **Pressed** or **Focus**, and more under **More States** (the `+`), like **Dark Mode**. See [Styles](/design/styles).

## Interact

Add [animations](/design/animations), like fading in as the block scrolls into view, and [interactions](/design/interactions), like a mobile menu that opens and closes.

## Check it before you publish

The editor already shows the real page, so most of the time you just look. To try links, menus and animations without the editing controls, choose **Preview** in **More Actions**, the **⋯** at the top. It shows your latest changes, even ones not saved yet. While a live page has nothing unpublished, the menu offers **View on Site** instead.

## Save and publish

Your work saves by itself as you go. Nobody sees it until you press **Publish** at the top. Templates and components work the same way: publishing one updates every page that uses it. See [Entries](/content/entries).

## Keyboard tips

- In a row of options, press `Tab` to reach it and the arrow keys to choose.
- `⌘D` duplicates the selected block, `⌫` deletes it.
- More in [Writing](/editing/writing#keyboard-shortcuts).
