---
id: 01m5x9f6g8vrdbm26dcz46cb9f
title: Styles
position: 1
description: Style any block in its Design tab, for every screen size and for hover, focus and other states.
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

::: callout {"props":{"tone":"tip","text":"Drag a number field's label sideways to change its value, or press <code>↑</code> and <code>↓</code>. Hold <code>⇧</code> for steps of 10."}}
:::

## Use your design system

Fields for colors, sizes and spacing show a small diamond when you point at them, **Design Tokens**. Click it and pick a value from your [design system](/design/design-system), like *primary* or *space 8*.

A block that uses a token keeps matching the rest of your site: change the token, and the block follows. Prefer tokens over typed-in values whenever one fits.

## Style for tablets and phones

Styles work desktop first. You design for a large screen, then adjust what needs to change on smaller ones.

1. Choose **Tablet** or **Phone** in the editor's top bar. The page switches to that layout, and a line at the top of the **Design** tab says which screens your changes reach, with **Back to Desktop**.
2. Change what should be different, like three columns becoming one.

A change for **Tablet** applies to tablets and phones; one for **Phone** only to phones.

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

A block's `style` maps a **variant** to CSS properties in camelCase:

```json
{
  "type": "box",
  "props": { "tag": "section" },
  "style": {
    "base": { "display": "grid", "gridTemplateColumns": "repeat(3, 1fr)", "gap": "token:space.8", "paddingBlock": "token:space.section" },
    "tablet": { "gridTemplateColumns": "1fr 1fr" },
    "mobile": { "gridTemplateColumns": "1fr" },
    "hover": { "transform": "translateY(-2px)" },
    "mobile:hover": { "transform": "none" }
  }
}
```

About 140 properties are allowed; `blocks/types` lists them with their inspector section. A few shorthands are accepted and stored under their full name: `paddingX`/`paddingY` (`paddingInline`/`paddingBlock`), `marginX`, `marginY`, `radius`, `shadow`, `bg`, `direction`, `justify`, `align`.

### Values

| You write | Becomes |
|---|---|
| `token:space.8` | `var(--space-8)` |
| `token:color.primary/40` | The color at 40% opacity |
| `0 8px 24px token:color.foreground/15` | Tokens work inside any value |
| `16` | `16px`, except for unitless properties like `opacity`, `zIndex`, `fontWeight`, `lineHeight`, `flexGrow`, `scale`, `aspectRatio` |
| `gridTemplateColumns: 3` | Three equal columns |
| `gridColumn: 2` | Span two columns |
| `backgroundImage: "media:01jc…"` | The uploaded image's URL |
| `clamp(2rem, 6vw, 5rem)`, `linear-gradient(…)` | As written |

Anything that could break out of a declaration, such as braces, semicolons, a hand-written `url()` or comments, is refused.

### Screen sizes

| Variant | Applies |
|---|---|
| `base` | Every screen |
| `tablet` | Below the `lg` breakpoint (1024px) |
| `mobile` | Below the `md` breakpoint (768px) |
| `sm`, `md`, `lg`, `xl` | At that breakpoint and up, for mobile-first styles |

### States

| State | Matches |
|---|---|
| `hover`, `active`, `focus`, `focus-visible`, `focus-within`, `disabled`, `checked` | The element itself (`hover` only on devices that can hover) |
| `before`, `after`, `placeholder`, `marker`, `selection` | Pseudo-elements (`before`/`after` get `content: ""` automatically) |
| `first`, `last`, `odd`, `even`, `empty` | Position among siblings |
| `open`, `current` | An open `<details>`, a link to the current page (`aria-current`) |
| `group-hover`, `group-focus` | An ancestor with the **Hover Group** behavior is hovered or focused |
| `dark` | Dark mode |
| `is-<name>` | The element has a custom state |
| `in-<name>` | An ancestor has it: "while the menu is open" |

Combine a screen size and a state with a colon: `mobile:hover`, `tablet:is-open`.

Custom states come from `logic.states` (`{ "open": "open" }` adds `is-open` while the `open` variable is true), from behaviors (**Scroll States** adds `is-scrolled`, **Scroll Spy** adds `is-current`) and from data (`bind: { "state:active": "item.active" }`).

### How it reaches the page

Each declaration becomes one short class (`.s4k2j9{gap:var(--space-8)}`), shared by every block with the same declaration, and only the classes a page uses are written into it. The editor and the public site use the same renderer and the same style data.
