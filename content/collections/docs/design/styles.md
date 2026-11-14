---
id: 01m5x9f6g8vrdbm26dcz46cb9f
title: Styles
position: 1
description: Style any block in its Design tab, with classes, for every screen size and for hover, focus and other states.
---
Every block can be styled on its own: its layout, size, spacing, type, colors, borders, shadows and more. You do it in the block's **Design** tab, and the page updates as you go.

![A heading selected on the home page, with its Design settings open on the right.](/media/screens/editor.webp)

## Style a block

1. Select a block on the page.
2. Open **Design** in the settings on the right.
3. Change what you need, section by section.

| Section | What it does |
|---|---|
| **Layout** | How a block arranges what's inside it: as a stack, a grid, or one after the other, with alignment and gaps |
| **Position** | Sticky, fixed or placed on top of other blocks |
| **Size** | Width and height: fill the space, fit the content or a fixed size, with limits, aspect ratio and overflow |
| **Spacing** | Margin outside and padding inside, drawn as a box you can drag |
| **Typography** | Font, size, weight, line height, letter spacing, style (upright or italic), case and decoration |
| **Fill** | A color, a gradient or an image behind the block, or gradient text |
| **Border** | Borders, outline and corner radius |
| **Effects** | Opacity, shadows, blur, frosted glass, blend modes and the mouse cursor |
| **Transform** | Move, scale, rotate and skew |
| **Transition** | Animate changes between states, like a smooth hover |

**Layout** only shows on blocks that hold other blocks. A section's **+** adds a property it has no row for yet, such as **Snap Align** in **Size** or **Underline Offset** in **Typography**, each with its own control.

Everything you set becomes a [Tailwind CSS](https://tailwindcss.com) class on the block. Type 16 for padding and the block gets `p-4`; pick your *primary* color as its fill and it gets `bg-primary`. You never have to read them, but they are always in sight at the top of the tab, and if you know Tailwind you can type them yourself.

::: callout {"props":{"tone":"tip","text":"Drag a number field's label sideways to change its value, or press <code>↑</code> and <code>↓</code>. Hold <code>⇧</code> for steps of 10."}}
:::

## Use your theme

Fields for colors, sizes and spacing show a small diamond when you point at them, **Theme Values**. Click it and pick a value from your [theme](/design/site-design), like *primary* or a step of spacing.

A block that uses a theme value keeps matching the rest of your site: change the value, and the block follows. Prefer them over typed-in values whenever one fits. **Detach** turns one back into a fixed value.

## Classes

The top of the **Design** tab shows the block's classes.

- Your site's own classes, like *card*, show as chips. A chip's menu has **Edit Class**, which opens it under **Styling → Classes**, **Detach**, which takes the class off and leaves its styles on the block, and **Remove Class**.
- **Add Class** searches your site's classes and Tailwind's as you type. Press Enter to add one. Several names typed or pasted with spaces between are added together.
- **Classes** opens the whole list as text. Edit it, or paste a list from anywhere. A name Tailwind can't read is underlined.
- The **⋯** menu has **Copy Classes** and **Create Class from Styles…**: it names the block's styles, like *card*, and saves them as a class of the site that other blocks can take.

The controls below write to the same list, so the two always agree.

## Style for different screens

Styles work phone first. What you set applies to every screen, and you add what should change from a wider screen up.

1. On the **Screen** row at the top of the **Design** tab, choose a size: **sm**, **md**, **lg**, **xl** or **2xl**. Point at one to see the width it starts at. **All** is every screen.
2. Change what should be different from that size up, like one column becoming three.

A change for **md** applies to *md* and everything wider, until a wider size says otherwise. For the rare style that should hold on small screens only, **More States** has **Smaller Screens Only**.

The sizes are your theme's: see **Layout → Breakpoints** in [Styling](/design/site-design). To see the page at another width, choose **Tablet** or **Phone** in the editor's top bar.

Field labels tell you where a value comes from. A darker label is set here, on this screen size and state: click it to reset it. A label with a small dot is inherited from a smaller screen or from the default state. A dot on a size or a state of the rows means it has styles of its own.

## Style hover, focus and other states

The **State** row chooses which state you're styling: **Default**, **Hover**, **Pressed** or **Focus**. Pick **Hover**, change the color, and the block changes color when visitors point at it.

**More States**, the **+** at the end of the row, has more:

| State | Use it for |
|---|---|
| **Before**, **After** | Decorations added before or after the block's content |
| **Placeholder** | The hint text in an empty input |
| **First Item**, **Last Item**, **Odd Items**, **Even Items** | Items in a list, like striped rows inside a Repeat |
| **Current Page** | A link to the page the visitor is on |
| **Hover on Group** | Reacting when a whole card is hovered, not only this block |
| **Dark Mode** | Values for visitors who use dark mode |
| **When Open** | An open accordion or dialog |
| **States of This Element** | A state set by an interaction, a behavior or data, see below |
| **Custom Variant…** | Any other Tailwind variant, by its name, like `aria-expanded` or `peer-checked` |

Add a **Transition** in the default state, and the change between states animates.

### Custom states

A custom state is a name, like *open* or *active*, that something else switches on and off. You style it here, and the block changes when it switches.

- An [interaction](/design/interactions) sets it: a menu is *open* while its button has been clicked.
- A [behavior](/design/interactions#behaviors) sets it: **Scroll States** marks a header *scrolled* once the page scrolls.
- [Data](/design/data) sets it: a link is *active* when it points to the page the visitor is on.

States the block or its parents set are listed under **States of This Element**, and a state with styles of its own carries a small dot. Choose a parent's state, like **in open**, to style this block while its parent is open. No script is needed.

## For developers

### How styles are stored

A block's `class` is a string of Tailwind CSS v4 classes, as you would write it in HTML:

```json
{
  "type": "box",
  "props": { "tag": "section" },
  "class": "grid grid-cols-1 gap-8 py-section transition-transform hover:-translate-y-0.5 md:grid-cols-2 lg:grid-cols-3"
}
```

Every utility and variant Tailwind has works. A class is any run of up to 200 characters without a space, a quote, `<`, `>` or a backtick; a block keeps each class once, in the order written, up to 200 of them. A name Tailwind doesn't know costs nothing: it stays on the element and no CSS is made for it.

### Values

| You write | Becomes |
|---|---|
| `gap-8` | Eight steps of the theme's spacing unit: `2rem` |
| `p-[13px]` | An arbitrary value, for what the scale lacks |
| `bg-primary`, `max-w-content`, `py-section` | A value of the [theme](/design/site-design#the-theme), by its name |
| `bg-primary/40` | The color at 40% opacity |
| `shadow-[0_8px_24px_rgb(0_0_0/0.15)]` | In an arbitrary value, an underscore is a space |
| `grid-cols-3`, `col-span-2` | Three equal columns; span two columns |
| `text-[clamp(2rem,6vw,5rem)]`, `bg-linear-to-r from-primary to-transparent` | Any CSS value; Tailwind's own gradients |
| `bg-(--scheme)` | A CSS variable of your own |

Keep to the theme's names and the scale. A color or a size the site lacks belongs in the theme, not in an arbitrary value on one block.

A picture from the media library is not a class: a block's `image` or `background_image` prop holds it, and what differs per item of a list is bound with `style:` (see [Showing content](/design/data)).

### Screen sizes

| Variant | Applies |
|---|---|
| No variant | Every screen |
| `sm:`, `md:`, `lg:`, `xl:`, `2xl:` | At that breakpoint and up: 640, 768, 1024, 1280 and 1536 pixels (40, 48, 64, 80 and 96rem) unless the theme's `--breakpoint-*` say otherwise |
| `max-md:`, `max-lg:` | Below that breakpoint only |
| `md:max-lg:` | Between two |
| `@md:`, `@lg:` | Container queries, inside an element with `@container` |

### States

| Variant | Matches |
|---|---|
| `hover:`, `active:`, `focus:`, `focus-visible:`, `focus-within:`, `disabled:`, `checked:` | The element itself (`hover:` only on devices that can hover) |
| `before:`, `after:`, `placeholder:`, `marker:`, `selection:` | Pseudo-elements (`before:` and `after:` get `content: ""` automatically) |
| `first:`, `last:`, `odd:`, `even:`, `empty:` | Position among siblings |
| `open:`, `current:` | An open `<details>` or `<dialog>`; a link to the current page (`aria-current`) |
| `group-hover:`, `group-focus:` | An ancestor with the class `group` is hovered or focused. The **Hover Group** behavior adds that class |
| `dark:` | Dark mode: the visitor's system, or a `data-theme` on the page or a section |
| `data-<name>:` | The element has a custom state: the attribute `data-<name>` |
| `in-data-<name>:` | An ancestor has it: "while the menu is open" |
| `group-data-<name>:` | An ancestor with the class `group` has it |

Variants stack, the screen size first: `md:hover:bg-primary`, `max-md:in-data-open:block`.

Custom states come from `logic.states` (`{ "open": "open" }` keeps the attribute `data-open` on the element while the `open` variable is true), from behaviors (**Scroll States** sets `data-scrolled` and `data-hidden`, **Scroll Spy** sets `data-current`) and from data (`bind: { "state:active": "item.active" }` sets `data-active`).

```json
{ "type": "icon", "props": { "icon": "plus" }, "class": "transition-transform in-data-open:rotate-45" }
```

### How it reaches the page

Tailwind itself compiles the site's stylesheet for exactly the classes the content uses, and every page links that one file. A class nobody uses is not in it. The editor compiles the same stylesheet in the browser, so the canvas and the public site look the same. See [Compiled CSS](/design/site-design#compiled-css).
