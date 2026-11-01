---
id: 01m5wn8rahj942kpc5xx6pns6s
title: Design system
position: 0
group: 'Foundations'
description: One file holds the site's tokens, fonts, element styles, button looks and page transition. The block workspace, the inspector, agents and the CSS all read from it.
---
The design system lives in `content/design/tokens.json`, next to your content, so it is versioned with the site and readable by agents. A site without one uses Lettern's defaults until you save.

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

## Tokens

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

- **Fluid values** — `{ "min": "1rem", "max": "1.25rem" }` — scale smoothly between a 360px and a 1280px screen.
- **Dark mode** — a token's `$extensions.cms.dark` value applies when the visitor prefers dark, or when the page is switched with the *Light / dark mode* action.
- Refer to a token anywhere a style takes a value: `token:color.primary`, with opacity `token:color.primary/20`, or inside a longer value: `0 8px 24px token:color.foreground/15`.

**Design → Design system** in the admin edits all of it: tokens (Color, Type, Space, Shape) with a live preview in light and dark, **Fonts**, **Elements** (element, prose and button styles), **Motion** (page transitions, duration and easing tokens) and **Code**. A change restyles every page and rebuilds the site.

## Element styles and prose

`styles` sets defaults for HTML elements — `html`, `body`, `h1`–`h6`, `p`, `a`, `a:hover`, `small`, `strong`, `em`, `mark`, `code`, `kbd`, `pre`, `blockquote`, `hr`, `ul`, `ol`, `li`, `img`, `figcaption`, `table`, `th`, `td`, `button`, `input`, `textarea`, `select`, `label`, `::selection`, `:focus-visible`, and `h1 em`, `h2 em`, `h3 em`, `h1 strong`, `h2 strong` for mixed-style headings. Keys are CSS properties in camelCase, like everywhere else in Lettern.

`prose` styles the same elements inside long-form text: a **Page content** block with the class `cms-prose` (the starter kit's article template uses it). Lettern ships sensible spacing for prose; override what you want.

Element styles sit in a low CSS layer, so a block's own styles always win.

## Buttons

`buttons` defines the looks of the **Button** block. Each key is a variant editors pick; each variant has `base`, `hover`, `active` and `focus-visible` styles. The core blocks offer `primary`, `secondary`, `ghost` and `link`; define more and they appear in the picker.

## Fonts

Fonts are self-hosted: files live in `content/design/fonts/` and are served from `/_cms/fonts/`, with `preload` for the ones the first screen needs. Add them on the **Fonts** tab, without touching files:

- **Add a Google font** — type a family name (`Inter Tight`). Lettern downloads the latin files (variable weights when the family has them) and adds them to `fonts`; visitors never contact Google. Agents use `design/fonts-import`.
- **Upload a font** — a `.woff2` file, with its family name. Agents use `design/fonts-upload` (the file as base64, a family, a weight such as `400` or `100 900`, and a style).

Then point a `font` token at the family.

## Page transitions

`transition` animates between pages with the browser's View Transitions: `fade`, `slide`, `scale` or `none`, with a `duration` in seconds. It works on the static site with no JavaScript, and is skipped for visitors who prefer reduced motion.

## Custom CSS and JavaScript

- `content/design/custom.css` is appended after everything else — use it for the rare thing the inspector can't express.
- `content/design/custom.js` loads as an ES module on every page. Use it to register Alpine components for behavior the builder can't express: listen for `cms:alpine` on `document` (its `detail` is Alpine), then give an element that component under **Interact → Code component** (`logic.component`).

```javascript
document.addEventListener('cms:alpine', (e) => {
  e.detail.data('pricing', () => ({
    yearly: false,
    get price() { return this.yearly ? 190 : 19 },
  }))
})
```

Both are edited on the **Code** tab, or with the `design/code` ability; both need the **Edit custom CSS and JavaScript** (`site.code`) permission — JavaScript runs on every page, so give it only to people you trust.

## For agents

`design/get` returns the tokens, fonts, element styles, buttons, transition, breakpoints, custom code and the templates entries can use; the `cms://site/design` context resource holds the same design system. `design/update` changes tokens (`{"tokens": {"color.primary": "#0f766e"}}`, `dark`, `remove`) and replaces whole sections (`styles`, `prose`, `buttons`, `fonts`, `transition`).
