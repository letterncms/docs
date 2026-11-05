---
id: 01m5x9f6g8vrdbm26dcz46cb9f
title: Styles
position: 1
description: Style any block in its Design tab with your design system's names, for every screen size and for hover, focus and other states.
---
Every block can be styled on its own: its layout, size, spacing, type, colors, borders, shadows and more. You do it in the block's **Design** tab, and the page updates as you go.

Every value you pick is a name from your [design system](/design/design-system), like *heading-2*, *foreground-muted* or *lg*, never a number you type. That's what keeps a site consistent as it grows: a block styled today still matches the rest of the site after you change your colors or fonts next year.

![A heading selected on the home page, with its Design settings open on the right.](/media/screens/editor.webp)

## Style a block

1. Select a block on the page.
2. Open **Design** in the settings on the right.
3. Change what you need, section by section.

| Section | What it does |
|---|---|
| **Layout** | How a block arranges what's inside it: as a stack, a grid of 1 to 24 columns or one after the other, with alignment, gaps, flow and container widths |
| **Grid Item**, **Stack Item** | How a block sits in its parent's grid or stack: how many columns it spans, the line it starts on, a full row, its order and its own alignment |
| **Position** | Sticky, fixed or placed on top of other blocks, with offsets and a layer |
| **Size** | Width and height: fill the space, fit the content, a fraction, a container width or a screen size, with limits, aspect ratio, overflow and fit |
| **Spacing** | Margin outside and padding inside, drawn as a box: each side steps through the spacing scale, the section and gutter spaces, or negative margins |
| **Typography** | A text style first, then font, size, weight, line height, letter spacing, style, decoration, case, wrapping, maximum lines, shadow and outline |
| **Color** | A scheme for the block and everything in it, then a background color, a gradient of your colors, an image or a texture |
| **Border** | Borders, outline and corner radius |
| **Effects** | Opacity, shadow, blur, background blur, brightness, contrast, saturation, grayscale, blend modes, masks and the mouse cursor |
| **Transform** | Move, scale, rotate and skew |
| **Transition** | Animate changes between states, like a smooth hover |

**Layout** only shows on blocks that hold other blocks, and **Grid Item** or **Stack Item** on blocks inside a grid or a stack.

::: callout {"props":{"tone":"tip","text":"Drag a field sideways, or press <code>↑</code> and <code>↓</code>, to step through its scale. Hold <code>⇧</code> for bigger steps. <code>Backspace</code> clears it."}}
:::

## Pick from your design system

Each field opens a list of the names it takes, in order, with a preview and what each one is on your site, like *lg: 24–30px*. Pick one, and the block uses that name: change it in the design system, and the block follows.

- **Colors** come from the block's scheme: *foreground*, *foreground-muted*, *background*, *surface*, *border* and the rest, and from your palettes: *primary*, the text on it (*on-primary*), its soft tint and its text color, plus shades for decoration. Add an opacity step, like *primary/20*. There's no hex value to type: roles keep their contrast in light and dark mode.
- **A scheme** recolors a whole section at once: put a band in *inverse*, *muted* or *primary*, and every color inside it, text, buttons and borders included, is worked out again for that background.
- **Type** starts with a text style, which sets font, size, weight, line height, letter spacing and case together. Change single properties after that only when you need to.
- **Flow** on a container spaces its children for you: *tight*, *normal*, *loose*, or *prose* for long text, with more space before headings and around images.

If the name you need isn't there, add it to the [design system](/design/design-system), like a brand color or a text style. Then it's on every list.

## Style for tablets and phones

Styles work desktop first. You design for a large screen, then adjust what needs to change on smaller ones. Type and spacing already scale smoothly with the screen, so you rarely need to change sizes: usually it's the layout, like three columns becoming one.

1. Choose **Tablet** or **Phone** in the editor's top bar. The page switches to that layout, and a line at the top of the **Design** tab says which screens your changes reach, with **Back to Desktop**.
2. Change what should be different.

A change for **Tablet** applies to tablets and phones; one for **Phone** only to phones. A scheme is the same on every screen size.

Field labels tell you where a value comes from. A darker label is set here, on this screen size and state: click it to reset it. A label with a small dot is inherited from a larger screen or from the default state.

## Style hover, focus and other states

The track at the top of the **Design** tab chooses which state you're styling: **Default**, **Hover**, **Pressed** or **Focus**. Pick **Hover**, change the color, and the block changes color when visitors point at it.

**More States**, the **+** at the end of the track, has more:

| State | Use it for |
|---|---|
| **Before**, **After** | Decorations added before or after the block's content |
| **Placeholder** | The hint text in an empty input |
| **First Item**, **Last Item**, **Odd Items**, **Even Items** | Items in a list, like striped rows inside a Repeat |
| **Current Page** | A link to the page the visitor is on |
| **Hover on Hover Group** | Reacting when a whole card is hovered, not only this block |
| **Dark Mode** | Values for visitors who use dark mode |
| **When Open** | An open accordion or dialog |
| **Custom State…** | A state set by an interaction, a behavior or data, see below |

Add a **Transition** in the default state, and the change between states animates.

### Custom states

A custom state is a name, like *open* or *active*, that something else switches on and off. You style it here, and the block changes when it switches.

- An [interaction](/design/interactions) sets it: a menu is *open* while its button has been clicked.
- A [behavior](/design/interactions#behaviors) sets it: **Scroll States** marks a header *scrolled* once the page scrolls.
- [Data](/design/data) sets it: a link is *active* when it points to the page the visitor is on.

States the block or its parents set appear on the track by themselves, and a state with styles of its own carries a small dot. Choose a parent's state, like **in open**, to style this block while its parent is open. No script is needed.

## For developers

### How styles are stored

A block's `style` maps CSS properties in camelCase to names of the [Lettern Design](https://design.lettern.org/spec/styles/) vocabulary. Properties at the top are the base; conditions sit beside them, each a style of its own:

```json
{
  "type": "box",
  "props": { "tag": "section" },
  "style": {
    "display": "grid",
    "gridTemplateColumns": "3",
    "gap": "lg",
    "paddingBlock": "section",
    "scheme": "inverse",
    "max-lg": { "gridTemplateColumns": "2" },
    "max-md": { "gridTemplateColumns": "1" },
    "hover": { "translateY": "-2xs" },
    "max-md:hover": { "translateY": "0" }
  }
}
```

The same with the base spelled out, `{ "base": { … }, "max-md": { … } }`, is just as valid, and is how Lettern saves it. `blocks/types` lists every property with its inspector section and the names it takes; the [styles reference](https://design.lettern.org/spec/styles/) has them all.

### Values

A value is one of:

| Kind | Examples |
|---|---|
| A name of the theme | `lg`, `section`, `foreground-muted`, `primary/40`, `heading-2`, `md`, `slow`, `expo` |
| A keyword of the property | `grid`, `center`, `uppercase`, `sticky` |
| A short composition of names | `padding: "lg xl"`, `gridTemplateColumns: "2fr 1fr"`, `gridColumn: "2 / span 6"`, `backgroundImage: "linear(to-br, primary, accent/50 60%)"` |
| An uploaded image | `backgroundImage: "media:01jc…"` |

Anything else, like `16px`, `#3b82f6` or `clamp(…)`, isn't in the vocabulary and is left out when the block is saved. Three properties set more than one thing: `text` (a text style), `flow` (`tight`, `normal`, `loose`, `prose`) and `scheme` (`light`, `dark`, `inverse`, `muted` or any palette). `flow`, `scheme` and `texture` become attributes (`data-scheme`), so they belong in the base only.

### Screen sizes

| Condition | Applies |
|---|---|
| base | Every screen |
| `max-lg` | Below 1024px: **Tablet**, and phones |
| `max-md` | Below 768px: **Phone** |
| `sm`, `md`, `lg`, `xl`, `2xl` | At that width and up, for mobile-first styles |
| `@xs` … `@4xl` | When the nearest container (`containerType: "inline-size"`) is that wide |

The narrower condition wins: `max-md` over `max-lg`, `lg` over `md`.

### States

| State | Matches |
|---|---|
| `hover`, `active`, `focus`, `focus-visible`, `focus-within`, `disabled`, `checked`, `invalid` | The element itself (`hover` only on devices that can hover) |
| `before`, `after`, `placeholder`, `marker`, `selection` | Pseudo-elements |
| `first`, `last`, `odd`, `even`, `empty` | Position among siblings |
| `open`, `current` | An open `<details>`, a link to the current page (`aria-current`) |
| `group-hover`, `group-focus` | An ancestor with the **Hover Group** behavior is hovered or focused |
| `dark`, `light`, `motion-safe`, `motion-reduce`, `print` | The visitor's preferences |
| `is-<name>` | The element has a custom state |
| `in-<name>` | An ancestor has it: "while the menu is open" |

Combine a screen size and a state with a colon, screen size first: `max-md:hover`, `max-lg:is-open`. A state wins over its screen size.

Custom states come from `logic.states` (`{ "open": "open" }` adds `is-open` while the `open` variable is true), from behaviors (**Scroll States** adds `is-scrolled`, **Scroll Spy** adds `is-current`) and from data (`bind: { "state:active": "item.active" }`).

### How it reaches the page

Each declaration becomes one short atomic class, named by a hash of what it does, so every block with the same `gap` shares a class and the CSS only grows with new decisions. Only the classes a page uses are written into it, in the `design.styles` cascade layer: above the theme, its element defaults and its components, so a block's own style always wins. `scheme`, `flow` and `texture` become `data-` attributes the theme's stylesheet answers to. The editor and the public site use the same renderer and the same style data.
