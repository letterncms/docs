---
id: 01m5x9f6g8vrdbm26dcz46cb9f
title: Styles
position: 1
group: 'Foundations'
description: Any block takes any CSS — layout, size, type, fills, borders, effects, transforms — per screen size and per state, with design tokens one click away.
---
Select a rendered block and open **Design** in the inspector. Each section edits real CSS: **Layout** (block, stack, grid, alignment, gap), **Position**, **Size** (fill, fit, fixed, limits, aspect ratio, overflow), **Spacing** (margin and padding on a box model), **Typography**, **Fill** (color, gradient, image, gradient text), **Border** and radius, **Effects** (opacity, shadows, blur, backdrop blur, blend modes, cursor), **Transform** and **Transition**. **CSS** at the bottom lists everything set at the current screen size and state, and adds any other property.

Numbers scrub: drag a field's label sideways, or press `↑` `↓` (`⇧` for steps of 10). The diamond in a field opens your [tokens](/design/design-system).

## How styles are stored

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

About 140 properties are allowed — `blocks/types` lists them with their inspector section. A few shorthands are accepted and stored under their full name: `paddingX`/`paddingY` (`paddingInline`/`paddingBlock`), `marginX`, `marginY`, `radius`, `shadow`, `bg`, `direction`, `justify`, `align`.

## Values

| You write | Becomes |
|---|---|
| `token:space.8` | `var(--space-8)` |
| `token:color.primary/40` | The color at 40% opacity |
| `0 8px 24px token:color.foreground/15` | Tokens work inside any value |
| `16` | `16px` — except unitless properties like `opacity`, `zIndex`, `fontWeight`, `lineHeight`, `flexGrow`, `scale`, `aspectRatio` |
| `gridTemplateColumns: 3` | Three equal columns |
| `gridColumn: 2` | Span two columns |
| `backgroundImage: "media:01jc…"` | The uploaded image's URL |
| `clamp(2rem, 6vw, 5rem)`, `linear-gradient(…)` | As written |

Anything that could break out of a declaration — braces, semicolons, `url()` written by hand, comments — is refused.

## Screen sizes

Styles are desktop-first, like you design:

| Variant | Applies |
|---|---|
| `base` | Every screen |
| `tablet` | Below the `lg` breakpoint (1024px) |
| `mobile` | Below the `md` breakpoint (768px) |
| `sm`, `md`, `lg`, `xl` | At that breakpoint and up, for mobile-first styles |

Choose Desktop, Tablet or Phone above the block inspector to edit that screen size. A field's label is **blue** when its value is set here and **amber** when it is inherited from a larger screen or the default state; click a blue label to reset it.

## States

The chips above the inspector choose the state you style: **Default**, **Hover**, **Pressed**, **Focus**, and with **+**:

| State | Matches |
|---|---|
| `hover`, `active`, `focus`, `focus-visible`, `focus-within`, `disabled`, `checked` | The element itself (`hover` only on devices that can hover) |
| `before`, `after`, `placeholder`, `marker`, `selection` | Pseudo-elements (`before`/`after` get `content: ""` automatically) |
| `first`, `last`, `odd`, `even`, `empty` | Position among siblings — handy inside a Repeat |
| `open`, `current` | An open `<details>`, a link to the current page (`aria-current`) |
| `group-hover`, `group-focus` | An ancestor with the **Hover group** behavior is hovered or focused |
| `dark` | Dark mode |
| `is-<name>` | The element has a custom state |
| `in-<name>` | An ancestor has it — “while the menu is open” |

Combine a screen size and a state with a colon: `mobile:hover`, `tablet:is-open`.

### Custom states

Custom states connect styling to everything else:

- [Interactions](/design/interactions) set them: `logic.states: { "open": "open" }` adds `is-open` while the `open` variable is true.
- [Behaviors](/design/interactions#behaviors) set them: **Scroll states** adds `is-scrolled`, **Scroll spy** adds `is-current`.
- [Data](/design/data) sets them: `bind: { "state:active": "item.active" }` adds `is-active` to the current menu link.

Style `is-open` on the element and `in-open` on its children, add a **Transition**, and the change animates — no script needed.

## How it reaches the page

Each declaration becomes one short class (`.s4k2j9{gap:var(--space-8)}`), shared by every block with the same declaration, and only the classes a page uses are written into it. The live editing surface and public site use the same renderer and style data.
