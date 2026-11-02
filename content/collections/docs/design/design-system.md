---
id: 01m5wn8rahj942kpc5xx6pns6s
title: Design system
position: 0
description: Your site's colors, fonts, spacing and button styles, in one place. Change them once and every page follows.
---
The design system holds the values your whole site is built from: colors, fonts, text sizes, spacing, corners, shadows and motion. Blocks use these values instead of fixed ones, so when you change your main color, every button, link and heading that uses it changes too.

![The design system: colors in the middle, a live preview of the site on the right.](/media/screens/design-system.webp)

Open it from **Settings → Design System**, or press `⌘K` and type *design*. The preview on the right shows your site as you change things, on desktop, tablet or phone, in light or dark.

## What's in it

The list on the left has two groups. **Tokens** are the named values blocks pick from. **Styles** decide how plain elements look before you style anything.

| Section | What you set |
|---|---|
| **Color** | Your palette: background, text, your brand colors, borders. Each color can have its own dark-mode value |
| **Typography** | Font families, the type scale, line heights, letter spacing and weights |
| **Spacing** | The spacing scale, content widths and the screen sizes the site adapts at |
| **Shape** | Corner radius and shadows |
| **Motion** | How pages change into each other, and durations and easing for transitions |
| **Fonts** | The font files your site uses |
| **Elements** | Default styles for headings, paragraphs, links, lists and other plain elements, and for long-form text |
| **Buttons** | The looks a **Button** block can take |
| **Custom Code** | Your own CSS and JavaScript, for the rare thing the editor can't do |

A *token* is just a named value, like *primary* for your brand color or *8* for a step of spacing. You give it a value once, and use the name everywhere.

## Change your colors

1. Open **Color**.
2. Click a color and pick a new value. The preview updates right away.
3. Switch the preview to dark to check the dark value too.
4. Press **Save** (`⌘S`).

Saving restyles every page and rebuilds the site. Use the **+** next to a group to add a token of your own, like an accent color.

## Add a font

Fonts are stored on your site, so visitors' browsers never contact another service to load them.

1. Open **Fonts**.
2. Type a family name under **Add a Google Font**, like *Inter Tight*, or drop a `.woff2` file to upload one.
3. Open **Typography** and point a font token, like *sans* or *display*, at the new family.

## Use tokens on a block

In a block's **Design** settings, fields that take a color, a size or a space have a small diamond: **Design Tokens**. Click it and pick a token. The block now follows that token, so it changes when the design system does.

Choose **Detach Token** to turn it back into a fixed value. See [Styles](/design/styles).

## Button styles

**Buttons** holds the looks a **Button** block can take, such as *primary*, *secondary*, *ghost* and *link*. Each has a normal, hover, pressed and focus style. Add a look and it appears in every Button's **Variant** menu.

## Page transitions

Under **Motion**, **Page Transition** animates the change from one page to the next: **Fade**, **Slide**, **Scale** or **None**, with a duration. It needs no script, and visitors who prefer reduced motion don't get it.

## Custom CSS and JavaScript

**Custom Code** holds CSS added after everything else, and JavaScript that runs on every page. You rarely need either: use them for the one thing the editor can't express.

::: callout {"props":{"tone":"warning","text":"JavaScript here runs on every page of your site. Editing it needs the <strong>Edit custom CSS and JavaScript</strong> permission: give it only to people you trust."}}
:::

## For developers

### The file

The design system is one file, `content/design/tokens.json`, next to your content, so it is versioned with the site. A site without one uses Lettern's defaults until you save.

```json
{
  "name": "Acme",
  "tokens": {
    "color": {
      "$type": "color",
      "background": { "$value": "#ffffff", "$extensions": { "cms": { "dark": "#0c0c0b" } } },
      "foreground": { "$value": "#161614", "$extensions": { "cms": { "dark": "#f2f2ee" } } },
      "primary": { "$value": "#1d4ed8" }
    },
    "font": { "sans": { "$value": ["Inter", "ui-sans-serif", "system-ui", "sans-serif"] } },
    "text": { "base": { "$value": { "min": "1rem", "max": "1.0625rem" } }, "5xl": { "$value": { "min": "2.75rem", "max": "5rem" } } },
    "space": { "4": { "$value": "1rem" }, "section": { "$value": { "min": "4rem", "max": "8rem" } } },
    "radius": { "md": { "$value": "0.625rem" } }
  },
  "fonts": [
    { "family": "Inter", "src": "fonts/InterVariable.woff2", "weight": "100 900", "style": "normal", "preload": true }
  ],
  "styles": {
    "body": { "fontFamily": "token:font.sans", "fontSize": "token:text.base", "color": "token:color.foreground", "backgroundColor": "token:color.background" },
    "h1": { "fontSize": "token:text.5xl", "lineHeight": "token:leading.tight", "textWrap": "balance" },
    "h1 em": { "fontFamily": "token:font.display", "fontStyle": "italic" }
  },
  "prose": { "h2": { "fontSize": "token:text.2xl" } },
  "buttons": {
    "primary": { "base": { "backgroundColor": "token:color.primary", "color": "token:color.primary-foreground" }, "hover": { "opacity": 0.9 } }
  },
  "transition": { "type": "fade", "duration": 0.25 }
}
```

### Tokens

Tokens use the [Design Tokens](https://www.designtokens.org/) format: groups of tokens with a `$value` and an optional `$type`.

| Group | CSS property prefix | Used for |
|---|---|---|
| `color` | `--color-` | Text, fills, borders, shadows |
| `font` | `--font-` | Font stacks |
| `text` | `--text-` | Font sizes |
| `leading`, `tracking`, `weight` | `--leading-`, `--tracking-`, `--font-weight-` | Line height, letter spacing, font weight |
| `space` | `--space-` | Padding, margins, gaps, offsets |
| `radius`, `shadow` | `--radius-`, `--shadow-` | Corners and shadows |
| `container` | `--container-` | Content widths |
| `breakpoint` | — | Screen sizes for responsive styles |
| `duration`, `ease` | `--duration-`, `--ease-` | Transitions |

- **Fluid values**, like `{ "min": "1rem", "max": "1.25rem" }`, scale smoothly between a 360px and a 1280px screen.
- **Dark mode**: a token's `$extensions.cms.dark` value applies when the visitor prefers dark, or when the page is switched with the **Light or Dark Mode** action.
- Refer to a token anywhere a style takes a value: `token:color.primary`, with opacity `token:color.primary/20`, or inside a longer value: `0 8px 24px token:color.foreground/15`.

### Element styles and prose

`styles` sets defaults for HTML elements: `html`, `body`, `h1`–`h6`, `p`, `a`, `a:hover`, `small`, `strong`, `em`, `mark`, `code`, `kbd`, `pre`, `blockquote`, `hr`, `ul`, `ol`, `li`, `img`, `figcaption`, `table`, `th`, `td`, `button`, `input`, `textarea`, `select`, `label`, `::selection`, `:focus-visible`, and `h1 em`, `h2 em`, `h3 em`, `h1 strong`, `h2 strong` for mixed-style headings. Keys are CSS properties in camelCase, like everywhere else in Lettern.

`prose` styles the same elements inside long-form text: a **Page Content** block with the class `cms-prose` (the starter's article template uses it). Lettern ships sensible spacing for prose; override what you want.

Element styles sit in a low CSS layer, so a block's own styles always win.

### Buttons

Each key of `buttons` is a variant editors pick; each variant has `base`, `hover`, `active` and `focus-visible` styles. The core blocks offer `primary`, `secondary`, `ghost` and `link`.

### Fonts

Font files live in `content/design/fonts/` and are served from `/_cms/fonts/`, with `preload` for the ones the first screen needs. **Add a Google Font** downloads the latin files (variable weights when the family has them) and adds them to `fonts`. Agents use `design/fonts-import` for that, and `design/fonts-upload` to upload one (the file as base64, a family, a weight such as `400` or `100 900`, and a style).

### Page transition

`transition` uses the browser's View Transitions: `type` is `fade`, `slide`, `scale` or `none`, with a `duration` in seconds. It works on the static site with no JavaScript, and is skipped for visitors who prefer reduced motion.

### Custom code files

- `content/design/custom.css` is appended after everything else.
- `content/design/custom.js` loads as an ES module on every page. Use it to register Alpine components for behavior the builder can't express: listen for `cms:alpine` on `document` (its `detail` is Alpine), then give an element that component under **Interact → Code Component** (`logic.component`).

```javascript
document.addEventListener('cms:alpine', (e) => {
  e.detail.data('pricing', () => ({
    yearly: false,
    get price() { return this.yearly ? 190 : 19 },
  }))
})
```

Both are edited under **Custom Code** or with the `design/code` ability, and both need the `site.code` permission.

### Abilities

`design/get` returns the tokens, fonts, element styles, buttons, transition, breakpoints, custom code and the templates entries can use; the `cms://site/design` context resource holds the same design system. `design/update` changes tokens (`{"tokens": {"color.primary": "#0f766e"}}`, `dark`, `remove`) and replaces whole sections (`styles`, `prose`, `buttons`, `fonts`, `transition`).
