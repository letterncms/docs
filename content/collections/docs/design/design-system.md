---
id: 01m5wn8rahj942kpc5xx6pns6s
title: Design system
position: 0
description: "Your site's theme in one place: a few decisions about color, type, space, shape and motion. Change one and every page follows, with contrast checked."
---
The design system is your site's theme: a handful of decisions, like your brand colors, your fonts, a body size and how roomy things are. Everything else follows from them: color palettes, a type scale, spacing, corners, shadows and motion, for light and dark mode, on every screen size.

Blocks never hold a fixed color or size. They use names from the theme, like *heading-2*, *foreground-muted* or *section*, so when you change your main color or your heading font, every page follows. And because every value is a name, nobody can type in one that doesn't belong: not an editor, not the assistant, not a plugin.

Lettern's design system is **Lettern Design**, an open standard for styling websites with names instead of CSS values. [design.lettern.org](https://design.lettern.org) has every name and what it means.

![The design system: the theme's settings in the middle, a live preview of the site on the right.](/media/screens/design-system.webp)

Open **Design System**, under **Design** in the sidebar, or press `⌘K` and type *design*. Its sections are listed under it in the sidebar. The preview on the right shows your site as you change things, on desktop, tablet or phone, in light or dark.

## What's in it

| Section | What you decide |
|---|---|
| **Color** | Your brand colors (primary, accent, secondary, neutral and any more you add), the status colors, and the background and text of light and dark mode. Below them, every palette made from your colors |
| **Typography** | Your fonts and their files, which font body text, headings and code use, the type scale, and the text styles blocks pick from |
| **Space and Layout** | The spacing scale, the space around sections and page edges, the rhythm between a container's children, and content widths |
| **Shape and Components** | Corner radius and shadow depth, and how buttons, cards and form fields look |
| **Motion** | How fast everything moves, and the transition between pages |
| **Elements** | How plain headings, paragraphs, links, lists and other elements look before a block styles them |
| **Contrast and Agents** | The contrast check of every color pair, and the theme as the assistant and AI agents read it |
| **Custom Code** | Your own JavaScript, for the rare behavior the editor can't build |

Press **Save** in the bar at the bottom, or `⌘S`, to keep your changes. **Discard** puts everything back. Saving restyles every page and rebuilds the site.

## Change your colors

1. Open **Color**.
2. Under **Brand**, click a color and pick a new one, or type its hex value. The preview updates right away.
3. Check **Palettes**: each of your colors becomes a palette of eleven shades, and the label on it shows the text color that stays readable on it.
4. Switch the preview to dark to see dark mode too.

You only pick the colors themselves. Everything blocks use is worked out from them: a fill and the text on it, a soft tint, the color as readable text, muted text, borders and surfaces. When text can't be read on your exact color, like white on a bright yellow, Lettern uses dark text instead, or moves the fill the smallest step it must and tells you so under the palette.

**Add a Brand Color** adds a palette of your own, like *lime*: blocks can then use *lime*, *on-lime*, *lime-soft* and *lime-text* like any other. Under **Modes**, choose which shades are the page's background and text in light and dark mode, or turn dark mode off.

## Add a font

Fonts are stored on your site, so visitors' browsers never contact another service to load them.

1. Open **Typography** and find **Font Files**.
2. Type a family name in **Google Font**, like *Inter Tight*, and press **Add**. Or drop a `.woff2` file to upload one.
3. Under **Families**, put the new font in a slot: *sans*, *serif*, *mono*, *display* or *condensed*.
4. **Body**, **Headings** and **Code** say which slot each kind of text uses. Headings use *display* unless you change it.

## Set the type scale

Under **Scale**, **Body Size** and **Ratio** each take two values: one for a narrow screen and one for a wide one. Every size is a step of the ratio above the body size, and type grows smoothly between the two screens, so headings are large on a desktop and sensible on a phone, without any extra settings. **Body Leading**, **Display Leading**, **Display Tracking** and **Heading Weight** tune the rest.

**Text Styles** are what blocks pick first: *display*, *heading-1* to *heading-6*, *lead*, *body*, *label*, *eyebrow*, *code* and more. Each puts a font, size, weight, line height, letter spacing and case under one name. Click one to change it, or press **Add a Text Style** for one of your own, like *price*.

## Space, shape and motion

- **Space and Layout**: **md** is the middle step of the spacing scale, again for a narrow and a wide screen; every other step is a multiple of it, and large steps shrink more on phones. **Roles** say which step is the space at the page's edges (*gutter*) and around sections. **Flow** sets the space between a container's children once, for the whole site, including *prose*, the rhythm of long text. **Containers** are the content widths, in rem.
- **Shape and Components**: **Radius** makes the whole site sharper or softer, and **Shadow Depth** flatter or deeper. **Buttons**, **Cards** and **Fields** choose their corners, text style, padding, shadow and border.
- **Motion**: **Speed** makes every transition and animation snappier (below 1) or calmer (above 1). **Between Pages** animates the change from one page to the next: **Fade**, **Slide**, **Scale** or **None**. It needs no script, and visitors who prefer reduced motion don't get it.

## Contrast is checked for you

Every text and border color is measured against every background it can land on, in light and dark mode and in every scheme, to the WCAG AA level. A miss shows as a red count in the top bar and in **Contrast and Agents**, with the pair and the ratio it needs. Fix it by choosing other colors or other background and text shades.

**Contrast and Agents** also shows the theme as the assistant and AI agents read it: a DESIGN.md with every name and what it is on your site.

## Use it on a block

A block's **Design** tab only offers names from the theme. Its color fields list your scheme's roles and palettes, its size fields the steps of the type scale, its spacing fields the spacing scale, each with what it is on your site, like *24–30px*. See [Styles](/design/styles).

When a block needs something the theme doesn't have, add it to the theme, like a brand color or a text style, rather than working around it. Then every page can use it.

## Custom JavaScript

**Custom Code** holds JavaScript that runs on every page, for scripts and small components the editor can't build. Anything visual belongs in the theme instead: there is no custom CSS.

::: callout {"props":{"tone":"warning","text":"JavaScript here runs on every page of your site. Editing it needs the <strong>Edit Custom JavaScript</strong> permission, marked <strong>Trusted Only</strong>: give it only to people you trust."}}
:::

## For developers

### The file

The theme is one file, `content/design/theme.json`, next to your content, so it is versioned with the site. It is a [Lettern Design theme](https://design.lettern.org/spec/theme/): only `color.primary` is required, everything else has a default. A site without one uses Lettern's default theme until you save.

```json
{
  "$schema": "https://design.lettern.org/v1/theme.schema.json",
  "name": "Acme",
  "color": {
    "primary": "#1d4ed8",
    "accent": "#ff5a1f",
    "neutral": "#6b6760",
    "palettes": { "lime": "#c6ff3d" },
    "light": { "background": "neutral-50", "foreground": "neutral-950" }
  },
  "font": {
    "sans": "Inter",
    "display": "Instrument Serif",
    "faces": [{ "family": "Inter", "src": "fonts/inter.woff2", "weight": "100 900", "preload": true }]
  },
  "type": {
    "base": [16, 18],
    "ratio": [1.2, 1.26],
    "weight": "medium",
    "styles": { "price": { "font": "mono", "size": "5xl", "weight": "medium" } }
  },
  "space": { "base": [16, 20] },
  "layout": { "section": "4xl" },
  "radius": 10,
  "shadow": { "strength": 0.8 },
  "motion": { "speed": 1, "page": "fade" },
  "flow": { "prose": { "before": "2xl", "after": "xs" } },
  "elements": { "a": { "color": "primary-text", "hover": { "textDecorationLine": "underline" } } },
  "recipes": { "button": { "radius": "full" }, "card": { "radius": "xl", "padding": "lg" } }
}
```

Seeds are the only raw values: colors as `#rrggbb` or `oklch()`, and the numbers behind sizes, steps, the radius and speeds. Everything else names something in the vocabulary. The [theme reference](https://design.lettern.org/spec/theme/) lists every key and its default, and the [JSON Schema](https://design.lettern.org/v1/theme.schema.json) checks the file in your editor.

### Scales and collections

The vocabulary has two kinds of names. **Scales** are closed: sizes (`2xs` to `12xl`), space steps (`3xs` to `7xl`), radii, shadows and durations have fixed names, and a theme only changes what they are. **Collections** are open: palettes, font families and text styles have names every theme provides, and a theme can add its own (`color.palettes`, `font.families`, `type.styles`). Whatever a theme adds, blocks, agents and plugins can use like the rest.

### Elements and recipes

`elements` sets the defaults of HTML elements (`h1`–`h6`, `p`, `a`, `small`, `strong`, `em`, `blockquote`, `code`, `ul`, `ol`, `li`, `hr`, `figcaption`, `table`, `th`, `td`, `label`, and `h1 em`, `h2 em` for mixed-style headings) as [styles](/design/styles), with names only. They sit in a low layer, so a block's own styles always win.

`recipes` tunes the components every block and plugin renders: `button` (`radius`, `text`, `weight`, `case`), `card` (`radius`, `padding`, `shadow`, `border`) and `field` (`radius`). See [components](https://design.lettern.org/spec/components/).

### Fonts

Font files live in `content/design/fonts/` and are served from `/_cms/fonts/`; `font.faces` lists them, with `preload` for the ones the first screen needs. **Google Font** under **Typography → Font Files** downloads the latin files (variable weights when the family has them) and adds their faces to the theme. Agents use `design/fonts-import` for that, and `design/fonts-upload` to upload one (the file as base64, a family, a weight such as `400` or `100 900`, and a style). Then put the family in a slot with `design/update`.

### Custom JavaScript

`content/design/custom.js` loads as an ES module on every page. Use it to register Alpine components for behavior the builder can't express: listen for `cms:alpine` on `document` (its `detail` is Alpine), then give an element that component under **Interact → Code Component** (`logic.component`).

```javascript
document.addEventListener('cms:alpine', (e) => {
  e.detail.data('pricing', () => ({
    yearly: false,
    get price() { return this.yearly ? 190 : 19 },
  }))
})
```

It is edited under **Custom Code** or with the `design/code` ability, and needs the `site.code` permission.

### How it reaches the page

The theme compiles to one stylesheet, `/_cms/site/design-<hash>.css`, with the theme's custom properties (`--color-foreground-muted`, `--space-lg`), text-style classes (`.text-heading-2`), schemes, flows, the components and the layout primitives, in the cascade layers `design.reset`, `design.tokens`, `design.base`, `design.layout`, `design.recipes` and `design.styles`. Block styles come last, in `design.styles`. Light and dark mode follow the visitor's system, or `data-mode` on the root, which the **Light or Dark Mode** action sets.

The engine is open source: `@letterncms/design` on npm and `letterncms/design` on Composer build the same stylesheet, check contrast and write DESIGN.md outside Lettern too.

### Abilities

- `design/get` returns the `theme`, what it resolves to (`resolved`: palettes, schemes, sizes, steps), the `catalog` of every style property and the names it takes, `design` (the DESIGN.md), the contrast `findings`, font files, the templates entries can use and the custom JavaScript. The `cms://site/design` context resource is the DESIGN.md with the theme.
- `design/update` takes `{ "theme": {…} }` and merges it into the saved theme: objects merge, anything else replaces, `null` removes a key. With `"replace": true` it replaces the whole theme. A theme with a name outside the vocabulary is refused with the reason, and nothing is saved. It returns the contrast findings.
- `design/preview` takes the same input and returns the `css`, `resolved` values and `findings` it would give, without saving.
- `design/code` takes `{ "js": "…" }`. `design/fonts-import` and `design/fonts-upload` add font faces to the theme.

```json
{ "theme": { "color": { "primary": "#0f766e" }, "radius": 4, "type": { "styles": { "heading-1": { "size": "7xl" } } } } }
```
