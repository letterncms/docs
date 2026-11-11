---
id: 01m5wn8rahj942kpc5xx6pns6s
title: Design system
position: 0
description: Your site's colors, fonts, spacing, buttons and form fields, in one place. Change them once and every page follows.
---
The design system holds the values your whole site is built from: colors, fonts, text sizes, spacing, corners, shadows and motion. Blocks use these values instead of fixed ones, so when you change your main color, every button, link and heading that uses it changes too.

![The design system: colors in the middle, a live preview of the site on the right.](/media/screens/design-system.webp)

Open **Design System**, under **Design** in the sidebar, or press `⌘K` and type *design*. Its sections are listed under it in the sidebar. The preview on the right shows your site as you change things, on desktop, tablet or phone, in light or dark.

## What's in it

The sections come in two groups. **Tokens** are the named values blocks pick from. **Styles** decide how plain elements, buttons and form fields look before you style anything.

| Section | What you set |
|---|---|
| **Colors** | Your palette: background, text, your brand colors, borders. Each color can have its own dark-mode value |
| **Typography** | The fonts your site uses, the type scale, line heights, letter spacing and weights |
| **Spacing** | The spacing scale, content widths and the screen sizes the site adapts at |
| **Sizes** | Small, medium and large, for buttons and form fields alike |
| **Shape** | Corner radius and shadows |
| **Motion** | How pages change into each other, and durations and easing for transitions |
| **Elements** | Default styles for headings, paragraphs, links, lists and other plain elements, everywhere on the site. Each starts empty: **Add a Property** adds what it sets, its ⋯ removes it |
| **Prose** | Long-form text: the space between its blocks, before and after headings and between list items, and **Elements in Prose**, how its elements look there only |
| **Buttons** | The looks a **Button** block can take: colors, border, corners, weight, shadow |
| **Form Fields** | How every text field, dropdown, checkbox and their labels look, on every form of the site |
| **Code** | Your own CSS and JavaScript, for what the editor can't do, and the libraries they import |

A *token* is just a named value, like *primary* for your brand color or *8* for a step of spacing. You give it a value once, and use the name everywhere.

## Change your colors

1. Open **Colors**.
2. Click a color and pick a new value. The preview updates right away.
3. Switch the preview to dark to check the dark value too.
4. Press **Save** in the bar at the bottom, or `⌘S`. **Discard** puts everything back.

Saving restyles every page and rebuilds the site. Use the **+** next to a group to add a token of your own, like an accent color.

## Add a font

Fonts are stored on your site, so visitors' browsers never contact another service to load them.

1. Open **Typography**. **Fonts** lists the roles your site uses, like *sans* and *display*.
2. Click a role's font. Pick one already on your site, or choose **Add a Google Font…** and type a name, like *Inter Tight*, or **Upload a .woff2 File…**. The new font is used right away.
3. Press **Save**. What a font falls back to while loading is in the row's **⋯** menu.

## Use tokens on a block

In a block's **Design** settings, fields that take a color, a size or a space show a small diamond when you point at them: **Design Tokens**. Click it and pick a token. The block now follows that token, so it changes when the design system does.

Choose **Detach Token** to turn it back into a fixed value. See [Styles](/design/styles).

## Sizes of buttons and fields

Buttons, form fields, tag fields and chips share one size scale: **Small**, **Medium** and **Large**. **Sizes** sets each size's height, padding and text size, and a button and a field of the same size line up, side by side or in a form; the preview shows them together. Empty, each takes Lettern's default from your type scale.

A **Button** block's **Size** picks S, M or L. Forms take the size set under **Form Fields → Size and Spacing**, and their send button with them.

## Button styles

**Buttons** holds the looks a **Button** block can take, such as *primary*, *secondary*, *ghost* and *link*: fill, border, radius, weight, letter spacing, text color, shadow and opacity, for **Default**, **Hover**, **Pressed** and **Focus**. A look has no size of its own, so every look comes in every size. The preview shows each in every state and size. Add a look with **+** and it appears in every Button's **Style** menu. **Shown On** names the background a look is made for, like a dark band, and the preview shows it there.

A Button with an icon and no label is square, as wide as it is tall. **Shape** **Round** makes it a circle, or a labelled button a pill. Give an icon-only button a **Name for Screen Readers**, like *Search*.

## Form fields

**Form Fields** styles every field on the site once: the forms you build, the sign-in and account pages, the checkout, list filters and the **Input** block. A field reads the same values wherever it is, so a fill, a border or a corner you set here reaches text fields, dropdowns, text areas, tag fields and file pickers at the same time.

![Form Fields: the checkbox controls on the left, every kind of field in each state on the right.](/media/screens/design-form-fields.webp)

Beside the controls, the preview shows every kind of field in each of its states, as your site draws them, in light or dark and at each screen width. Opening a row brings its part into view and marks it. You can click and type in it. Changes show at once and are saved with **Save**.

| Row | What you set |
|---|---|
| **All Fields** | Fill, border, radius, text color, placeholder and shadow, for every boxed field |
| **States** | How a field looks on **Hover**, with **Focus** (border and ring), when **Invalid** and when **Disabled** |
| **Labels and Help** | Label size, weight and color, the required mark, help text |
| **Size and Spacing** | The size of fields in forms (S, M or L), and the space between fields, from label to field, between options, and from a checkbox to its text |
| **Dropdowns**, **Text Areas** | The arrow's color and size; a text area's minimum height and whether it can be resized |
| **Checkboxes** | Size, radius, fill, border, checked color, and the mark: a check, a square or a dot, light, regular or bold, at any size |
| **Radio Buttons** | Size, checked color, and the dot: on a filled circle or in a ring |
| **Switches** | Width, height, radius, the off and on colors, and the knob with its inset and shadow |
| **Sliders** | The track, the part that's filled, and the thumb |
| **Tag Fields**, **Chips**, **File Pickers** | Tags in a tag field, options shown as pills, the button of a file picker |

Every control shows what applies while it's empty: a token, like *raised* or *primary*, or what the default does. Radio buttons, switches and sliders take your checkbox's checked color until you give them their own, and checkboxes take the fill and border of **All Fields**. A dot beside a row means you changed something in it; **Reset to Defaults** in its menu clears it.

## Page transitions

Under **Motion**, **Page Transition** animates the change from one page to the next: **Fade**, **Slide**, **Scale** or **None**, with a duration. It needs no script, and visitors who prefer reduced motion don't get it.

**Page Loads** says how a link gets to the next page: **Full Page**, or **Instant**, which swaps the page in place so chosen elements live on. See [Navigation without page loads](/design/page-navigation).

## Long-form text

**Prose** is how long-form text looks: an article, a doc, a post's body. Turn on **Prose**, under **Typography** in the **Design** tab, on a template's **Page Content** block or on any **Box**. Its blocks are then spaced as one flow, whatever kind they are: set the space between blocks, before and after headings and between list items once, and an image or a block of your own keeps the same rhythm as the paragraphs around it. Below that, style how its headings, links, lists and code look. Opening one in the list shows it in the preview's sample article, which has every element prose can style.

A block of your own inside prose keeps its own layout: prose spaces the blocks directly in it, and styles text, not a **Box** or **Repeat** drawn as a list or a link. A callout with paragraphs of its own turns on **Prose** too, and its text is spaced the same way.

## Custom CSS and JavaScript

**Code** holds the site's own CSS and JavaScript. **Site CSS** is added after everything else, and **Site JavaScript** runs on every page. You rarely need either: use them for the one thing the editor can't express.

Under them, **Styles** and **Scripts** list the design's other files, which load only where you say, and **Libraries** lists what scripts import. See [Scripts and styles](/design/code).

::: callout {"props":{"tone":"warning","text":"JavaScript here runs on every page of your site. Editing it needs the <strong>Edit Custom CSS and JavaScript</strong> permission, marked <strong>Trusted Only</strong>: give it only to people you trust."}}
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
  "prose": { "spacing": { "blocks": "1.1em" }, "h2": { "fontSize": "token:text.2xl" } },
  "buttons": {
    "primary": { "base": { "backgroundColor": "token:color.primary", "color": "token:color.primary-foreground" }, "hover": { "opacity": 0.9 } }
  },
  "fields": {
    "base": { "height": "3rem", "borderRadius": "token:radius.md", "backgroundColor": "token:color.background" },
    "focus": { "borderColor": "token:color.primary" },
    "label": { "fontWeight": "token:weight.semibold" }
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
| `control` | `--control-` | The sizes of buttons and fields: `sm-height`, `sm-padding`, `sm-text`, and the same for `md` and `lg` |
| `breakpoint` | — | Screen sizes for responsive styles |
| `duration`, `ease` | `--duration-`, `--ease-` | Transitions |

- **Fluid values**, like `{ "min": "1rem", "max": "1.25rem" }`, scale smoothly between a 360px and a 1280px screen.
- **Dark mode**: a token's `$extensions.cms.dark` value applies when the visitor prefers dark, or when the page is switched with the **Light or Dark Mode** action.
- Refer to a token anywhere a style takes a value: `token:color.primary`, with opacity `token:color.primary/20`, or inside a longer value: `0 8px 24px token:color.foreground/15`.

### Element styles

`styles` sets defaults for HTML elements: `html`, `body`, `h1`–`h6`, `p`, `a`, `a:hover`, `small`, `strong`, `em`, `mark`, `code`, `kbd`, `pre`, `blockquote`, `hr`, `ul`, `ol`, `li`, `img`, `figcaption`, `table`, `th`, `td`, `::selection`, `:focus-visible`, and `h1 em`, `h2 em`, `h3 em`, `h1 strong`, `h2 strong` for mixed-style headings. Keys are CSS properties in camelCase, like everywhere else in Lettern.

Beside those, `styles` and `prose` take any tag, alone or up to three deep, with a space (inside) or ` > ` (directly inside) between them, and one state or part at the end: `"h1 em"`, `"li > a"`, `"nav a:hover"`, `"li::marker"`. Classes, ids and attributes stay with `custom.css`.

Element styles sit in a low CSS layer, so a block's own styles always win.

### Prose

`prose` is long-form text: any **Page Content** or **Box** with **Prose** on (`"props": { "prose": true }`; the starter's article template has it). Its blocks are spaced as one flow, whatever they are, a paragraph, an image or a block of your own:

| `spacing` | Default | Space |
|---|---|---|
| `blocks` | `1.1em` | Between one block and the next |
| `headings` | `1.8em` | Before a heading |
| `afterHeadings` | `0.6em` | After a heading |
| `items` | `0.35em` | Between list items |

The other keys style the same elements as `styles`, inside prose. An element's top margin (`marginTop`) replaces the space before it: `"h2": { "marginTop": "2.5rem" }`. A **Page Content** without a container is part of the flow around it.

### Buttons

Each key of `buttons` is a variant editors pick as a Button's **Style**; each variant has `base`, `hover`, `active` and `focus-visible` styles, all edited in the Design System, and an optional `surface`, the background it's made for (`"token:color.band"`), where the preview shows it. The core blocks offer `primary`, `secondary`, `ghost` and `link`.

A variant is a look. Its height, padding and text size are the control size's, so properties that would size a button (`height`, `padding…`, `fontSize`, `lineHeight`, `width`) are left out when it compiles. Variants sit in a cascade layer between the base and the shapes, so a variant can't undo a shape or a state:

| Attribute | Does |
|---|---|
| `data-size="sm"`, `md`, `lg` | The control size, on the button or anything around it (`--control-height`, `--control-padding`, `--control-text`) |
| `data-icon-only` | A square button, as wide as it is tall; give it an `aria-label` |
| `data-shape="round"` | A circle, or with a label a pill |

### Form fields

`fields` sets every form field's look, part by part, over Lettern's defaults. Each property becomes a CSS custom property (`--field-background`, `--field-checkbox-checked`…) that one stylesheet reads for every kind of field.

```json
"fields": {
  "field": { "background": "token:color.raised", "borderColor": "token:color.border", "radius": "token:radius.md" },
  "spacing": { "size": "lg" },
  "focus": { "borderColor": "token:color.primary" },
  "label": { "fontWeight": "token:weight.semibold" },
  "checkbox": { "radius": "4px", "mark": "check", "markWeight": "bold" },
  "radio": { "style": "ring" },
  "switch": { "on": "field:checkbox.checked", "height": "1.5rem" }
}
```

| Part | Properties |
|---|---|
| `field` | `background`, `borderWidth`, `borderColor`, `radius`, `color`, `placeholder`, `shadow` |
| `hover`, `focus`, `invalid`, `disabled` | `background`, `borderColor`; focus adds `ringWidth`, `ringColor`; invalid has `color`, `ringColor`; disabled has `opacity` |
| `label`, `help` | `fontSize`, `fontWeight`, `color`, and `required` for the required mark |
| `spacing` | `size` (`sm`, `md`, `lg`: fields in forms), `fields`, `label`, `list`, `choice` |
| `select`, `textarea` | `arrowColor`, `arrowSize`; `minHeight`, `resize` (`vertical` or `none`) |
| `checkbox` | `size`, `radius`, `background`, `borderColor`, `checked`, `markColor`, `mark` (`check`, `square`, `dot`), `markWeight` (`light`, `regular`, `bold`), `markSize` |
| `radio` | `size`, `style` (`dot`, `ring`), `checked`, `dotColor`, `dotSize` |
| `switch` | `width`, `height`, `radius`, `off`, `on`, `knob`, `inset`, `knobShadow` |
| `slider` | `trackHeight`, `track`, `fill`, `radius`, `thumbSize`, `thumb`, `thumbBorder`, `thumbShadow` |
| `tags`, `chips`, `file` | `background`, `color`, `radius`; chips add `borderColor`, `selected`, `selectedText` |

How big a field is comes from the `control` tokens, like a button's. A value is CSS, a token, or `field:part.key` to follow another property. `design/get` returns each property's type and default as `fieldStyles`.

To give your own markup the same look, use the classes:

| Class | On |
|---|---|
| `cms-form`, `cms-field` | A form, and a field in it: its label, control and help, spaced |
| `cms-label`, `cms-help`, `cms-msg` | A label or legend, help text, an error message |
| `cms-input` | A text field of any type, a `select`, a `textarea`, a file picker |
| `cms-check`, `cms-radio`, `cms-switch` | `<input type="checkbox">`, `<input type="radio">`, `<input type="checkbox" role="switch">`, inside `<label class="cms-choice">` |
| `cms-range` | `<input type="range">`; `style="--cms-range: 0.4"` fills its track |
| `cms-tags`, `cms-chip` | A tag field; a pill holding a checkbox or radio |

A field is invalid with `aria-invalid="true"` or inside `.is-invalid`, and takes its size from `data-size` like a button.

### Fonts

Font files live in `content/design/fonts/` and are served from `/_cms/fonts/`, with `preload` for the ones the first screen needs. **Add a Google Font…** in a font's picker under **Typography → Fonts** downloads the latin files and adds them to `fonts`. It takes what the family really has: a variable family is one file for the weights its axis spans (EB Garamond is 400 to 800, not 100 to 900), a static family the weights it has, and no file is saved twice. Agents use `design/fonts-import` for that, with `style` (`normal`, `italic` or `both`) and, for a static family, `weights`, and `design/fonts-upload` to upload one (the file as base64, a family, a weight such as `400` or `100 900`, and a style).

A font face can name what is drawn until it arrives, so text doesn't move when the font loads: `fallback`, a local font such as Arial, with `sizeAdjust`, `ascentOverride`, `descentOverride` and `lineGapOverride`.

```json
{ "family": "Inter Tight", "fallback": "Arial", "sizeAdjust": "102%", "ascentOverride": "98%", "descentOverride": "26%", "lineGapOverride": "0%" }
```

Font tokens that name the family get that stand-in by themselves.

### Page transition

`transition` uses the browser's View Transitions: `type` is `fade`, `slide`, `scale` or `none`, with a `duration` in seconds. It works on the static site with no JavaScript, and is skipped for visitors who prefer reduced motion. `navigation` is `document` (the default) or `client`: see [Navigation without page loads](/design/page-navigation).

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

Both are edited under **Code** or with the `design-code/set-custom` ability, and both need the `site.code` permission. Scripts and stylesheets that load only on some pages, and the libraries they import, are on [Scripts and styles](/design/code).

### Abilities

`design/get` returns the tokens, fonts, element styles, buttons, form fields, transition, breakpoints, custom code and the templates entries can use; the `cms://site/design` context resource holds the same design system. `design/update` changes tokens (`{"tokens": {"color.primary": "#0f766e"}}`, `dark`, `remove`) and replaces whole sections (`styles`, `prose`, `buttons`, `fields`, `fonts`, `transition`).
