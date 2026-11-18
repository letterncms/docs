---
id: 01m5x9f6g8vrdbm26dcz46cb9f
title: Classes
position: 1
description: Style any block in its Design tab, on desktop, tablet and phone, and for hover, focus and other states. Everything you set is a class, and your site keeps classes of its own.
---
Every block can be styled on its own: its layout, size, spacing, type, colors, borders, shadows and more. You do it in the block's **Design** tab, and the page updates as you go. Everything you set becomes a class on the block, and your site keeps classes of its own, like `card`, that any block can wear.

![A heading selected on the home page, with its Design settings open on the right.](/media/screens/editor.webp)

## Style a block

1. Select a block on the page.
2. Open **Design** in the settings on the right.
3. Change what you need, section by section.

The tab starts with **State**, what you are styling (see below), and **Classes**, every class the block wears. Under them are its sections:

| Section | What it does |
|---|---|
| **Layout** | How a block arranges what's inside it: as a stack, a grid, or one after the other, with alignment and gaps |
| **Position** | Sticky, fixed or placed on top of other blocks |
| **Size** | Width and height: fill the space, fit the content or a fixed size, with limits, aspect ratio and overflow |
| **Spacing** | Margin outside and padding inside, drawn as a box you can drag. Click a side to type a value or pick one from the spacing scale, in pixels, or one of your theme's named spaces |
| **Typography** | Font, size, weight, line height, letter spacing, style (upright or italic), case and decoration |
| **Fill** | A color, a gradient or an image behind the block, or gradient text |
| **Border** | Borders, outline and corner radius |
| **Effects** | Opacity, shadows, blur, frosted glass, blend modes and the mouse cursor |
| **Transform** | Move, scale, rotate and skew |
| **Transition** | Animate changes between states, like a smooth hover |

**Layout** only shows on blocks that hold other blocks. A section's **+** adds a property it has no row for yet, such as **Snap Align** in **Size** or **Underline Offset** in **Typography**, each with its own control.

What you set is written as [Tailwind CSS](https://tailwindcss.com) classes. Type 16 for padding and the block gets `p-4`; pick your *primary* color as its fill and it gets `bg-primary`. You never have to read them; if you know Tailwind, they are all under **Classes**, and you can type them yourself.

::: callout {"props":{"tone":"tip","text":"Drag a number field's label sideways to change its value, or press <code>↑</code> and <code>↓</code>. Hold <code>⇧</code> for steps of 10."}}
:::

## Use your theme

Fields for sizes and spacing show a small diamond when you point at them, **Theme Values**. Click it and pick a value from your [theme](/design/site-design), like a step of spacing. A color field opens on your theme's colors, by name; **Palette** has Tailwind's colors, a swatch for every shade, and **Custom** any color you mix or type.

A block that uses a theme value keeps matching the rest of your site: change the value, and the block follows. Prefer them over typed-in values whenever one fits. **Detach** turns one back into a fixed value.

## The Classes field

**Classes**, at the top of the **Design** tab, holds every class the block wears, in one field, each written as it is: `flex`, `p-4`, `card`. It is folded like the sections under it; open it to see them.

- Press ↓ in the field to list your site's classes, and pick one to give it to the block.
- Type in it to find any class: Tailwind's are listed first, then **Site Classes**, then **Schemes**. Enter, Tab or a space takes what you typed. Several names pasted with spaces between are added together, and a name Tailwind can't read is underlined.
- Click a Tailwind class to change it where it stands. Its **×**, or Backspace in the empty field, takes a class off.

The controls under it write the same list, so the two always agree. The **⋯** of **Classes** has **Copy Classes**, which copies them all.

## Classes of your site

A class of your site is a look it keeps under a name, like `lede`, `card`, `btn-primary` or the scheme `scheme-tide`: the same on every block that wears it, and changed in one place, under **Design → Styles** (a scheme under **Design → Colors**). In the **Classes** field, your site's classes come first, as names on a raised chip; Tailwind's follow, as code.

- Click one of them for its menu: **Edit Class** opens it under **Design → Styles**, **Detach Class** takes it off and leaves what it set on the block, and **Remove Class** takes it off.
- **Save as Class…**, in the **⋯** of **Classes**, names what you set on the block, like *card*, and saves it as a class other blocks can wear. What you set for tablets and phones stays on the block.

## Style for different screens

Choose **Desktop**, **Tablet** or **Phone** in the editor's top bar. The page shows at that width, and the **Design** tab styles it there.

1. Style the block on **Desktop**: that holds on every screen.
2. Switch to **Tablet** or **Phone** and change what should be different there, like three columns becoming one. Desktop stays as it was.

A change on **Tablet** holds on tablets and phones, below the *lg* screen size; one on **Phone** only on phones, below *md*. The sizes are your theme's: see **Design → Layout → Breakpoints** in your [theme](/design/site-design).

Field labels tell you where a value comes from. A label on a colored background is set here, on this screen and state: click it to reset it. A label on a gray background comes from a larger screen, another state or the component. A section with a value set here carries a colored dot beside its title; one whose values only come from elsewhere, a gray one. The **State** field shows the dot only when the chosen state has styles of its own.

## Style hover, focus and other states

**State**, the first row of the **Design** tab, chooses which state you're styling: **Default**, **Hover**, **Pressed** or **Focus**. Pick **Hover**, change the color, and the block changes color when visitors point at it. While you style a state, the block you selected is drawn in it on the page, hovered, pressed or focused, and the field stands out, so you always know you're not styling the block itself. A state with styles of its own carries a dot.

Further down its list are more states:

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

States the block or its parents set are listed under **States of This Element**, in the list of **State**. Choose a parent's state, like **in open**, to style this block while its parent is open. No script is needed.

## For developers

### How classes are stored

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
| `max-md:`, `max-lg:` | Below that breakpoint only. **Phone** writes `max-md:`, **Tablet** `max-lg:` |
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

The **Design** tab reads classes written either way. It shows what wins at the screen you see: on **Desktop**, a block with `grid-cols-1 md:grid-cols-3` shows three columns, and changing them changes `md:grid-cols-3`.

Custom states come from `logic.states` (`{ "open": "open" }` keeps the attribute `data-open` on the element while the `open` variable is true), from behaviors (**Scroll States** sets `data-scrolled` and `data-hidden`, **Scroll Spy** sets `data-current`) and from data (`bind: { "state:active": "item.active" }` sets `data-active`).

```json
{ "type": "icon", "props": { "icon": "plus" }, "class": "transition-transform in-data-open:rotate-45" }
```

### How it reaches the page

Tailwind compiles the site's stylesheet for exactly the classes the content uses, and every page links that one file. A class nobody uses is not in it. The server compiles it whenever the content changes, also when an agent changes it over the API; the editor compiles the same stylesheet in the browser as you type, so the canvas and the public site look the same. See [Compiled CSS](/design/site-design#compiled-css).
