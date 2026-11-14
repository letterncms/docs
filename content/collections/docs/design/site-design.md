---
id: 01m5wn8rahj942kpc5xx6pns6s
title: Styling
position: 0
description: Your site's colors, fonts, spacing, classes and element styles, in one place. Change them once and every page follows.
---
The styling holds the values your whole site is built from: colors, fonts, text sizes, spacing, corners, shadows and motion. Blocks use these values instead of fixed ones, so when you change your main color, every button, link and heading that uses it changes too.

It is [Tailwind CSS](https://tailwindcss.com): one stylesheet holds the theme, and blocks carry Tailwind classes. You don't need to know Tailwind to use this page, and if you do, everything works the way you expect.

![The styling: colors in the middle, a live preview of the site on the right.](/media/screens/design.webp)

Open **Styling** in the sidebar, or press `⌘K` and type *styling*. Its sections are listed under it in the sidebar. The preview on the right shows your site as you change things, on desktop, tablet or phone, and in light or dark when the site has dark colors.

## What's in it

The sections come in two groups. **Theme** holds the named values blocks pick from. **Styles** holds your own classes, how plain elements look before you style anything, and the stylesheet itself.

| Section | What you set |
|---|---|
| **Colors** | Your palette: background, text, your brand colors, borders. With **Dark Mode** on, each color has a light and a dark value |
| **Typography** | The fonts your site uses, text sizes, weights, line heights and letter spacing |
| **Layout** | The spacing unit, spaces with a name, content widths and the screen sizes the site adapts at |
| **Shape** | Corner radius and shadows |
| **Motion** | Easing curves, and how pages change into each other |
| **Classes** | Looks with a name, like *card* or *btn-primary*, that any block can carry |
| **Elements** | Default styles for the page, headings, paragraphs, links and other plain elements, everywhere on the site |
| **Code** | The stylesheet as text, your own JavaScript, and the libraries it imports |

Every value in the theme has a name, like *primary* for your brand color or *content* for a width. You give it a value once, and use the name everywhere.

## Change your colors

1. Open **Colors**.
2. Click a color and pick a new value. The preview updates right away.
3. With **Dark Mode** on, each color has a second value. Switch the preview to dark to check it.
4. Press **Save** in the bar at the bottom, or `⌘S`. **Discard** puts everything back.

Saving restyles every page and rebuilds the site. **Add Color** adds a color of your own, like *accent*. **Tailwind Palette** keeps Tailwind's own colors, such as *red-500*, available beside yours: turn it off and only your colors exist.

## Add a font

Fonts are stored on your site, so visitors' browsers never contact another service to load them.

1. Open **Typography**. **Fonts** lists the roles your site uses, like *sans* and *display*.
2. Click a role's font. Pick one already on your site, or choose **Add a Google Font…** and type a name, like *Inter Tight*, or **Upload a .woff2 File…**. The new font is used right away.
3. Press **Save**. What a font falls back to while loading, and **Preload**, are in the row's **⋯** menu.

## Use the theme on a block

In a block's **Design** tab, fields that take a color, a size or a space show a small diamond when you point at them: **Theme Values**. Click it and pick one. The block now follows that value, so it changes when the theme does.

Choose **Detach** to turn it back into a fixed value. See [Styles](/design/styles).

## Classes

A class is a look with a name. Make a *card* once, with its corners, border and padding, and give it to every block that should look like one. Change the class, and they all change.

1. Open **Classes** and choose **New Class**. Name it, like *card*.
2. Style it with the same controls as a block's **Design** tab, for every screen size and state.
3. Press **Save**. The class is now offered on every block, under **Add Class** in its **Design** tab.

A class's **⋯** menu has **Rename…**, **Duplicate…** and **Delete**. You can also make one from a block you already styled: see [Styles](/design/styles#classes).

## Element styles

**Elements** decides how plain elements look before a block says otherwise: the **Page**, **Heading 1** to **Heading 6**, **Paragraph**, **Link**, **Small Text**, **Quote**, **Code** and the **Selection**. Open one and style it like a block. **Add Element** styles anything else by its CSS selector, like `figcaption` or `h1 em`. **Clear Styles** in an element's **⋯** menu empties it.

A block's own classes always win over an element's style.

## Button styles

A **Button** block's **Style** menu lists the looks your site has, such as *primary*, *secondary*, *ghost* and *link*. Each is a class whose name starts with `btn-`: open *btn-primary* under **Classes** to change its fill, border, corners or text color, and choose **Hover** on the **State** row for how it looks when pointed at. Make a class named *btn-outline* and **Outline** appears in every Button's **Style** menu.

A look has no size of its own, so every look comes in every size: a Button's **Size** picks S, M or L. A Button with an icon and no label is square, as wide as it is tall. **Shape** **Round** makes it a circle, or a labelled button a pill. Give an icon-only button a **Name for Screen Readers**, like *Search*.

## Sizes of buttons and fields

Buttons, form fields, tag fields and chips share one size scale: small, medium and large. Each size has a height, a padding and a text size, so a button and a field of the same size line up, side by side or in a form. Forms use medium, and their send button with them.

The sizes are values of the theme (`--control-md-height` and the like). Change them in the stylesheet under **Code**: see [Buttons](#buttons) below.

## Form fields

Every field on the site looks the same: the forms you build, the sign-in and account pages, the checkout, list filters and the **Input** block. A field reads its fill, border, corners and colors from one set of values, so what you set once reaches text fields, dropdowns, text areas, checkboxes, switches, tag fields and file pickers at the same time.

Out of the box, fields follow your theme: its *raised*, *border*, *primary* and *muted* colors and its *md* radius. To give them a look of their own, set their values in the stylesheet under **Code**: see [Field variables](#field-variables) below.

## Page transitions

Under **Motion**, **Page Transition** animates the change from one page to the next: **Effect** is **Fade**, **Slide**, **Scale** or **None**, with a **Duration**. It needs no script, and visitors who prefer reduced motion don't get it.

**Page Loads** says how a link gets to the next page: **Full Page**, or **Instant**, which swaps the page in place so chosen elements live on. See [Navigation without page loads](/design/page-navigation).

## Long-form text

**Prose** is how long-form text looks: an article, a doc, a post's body. Turn on **Prose**, under **Typography** in the **Design** tab, on a template's **Page Content** block or on any **Box**. Its blocks are then spaced as one flow, whatever kind they are: an image or a block of your own keeps the same rhythm as the paragraphs around it, with more room before a heading and less after it, and lists, links, quotes and inline code are drawn as text.

A block of your own inside prose keeps its own layout: prose spaces the blocks directly in it, and styles text, not a **Box** or **Repeat** drawn as a list or a link. A callout with paragraphs of its own turns on **Prose** too, and its text is spaced the same way.

The spaces, and how headings and other elements look inside prose only, are set in the stylesheet: see [Prose](#prose) below.

## Stylesheet and JavaScript

**Code** shows the stylesheet as text: the same one every other section edits, so a change made here shows in the controls, and the other way around. Anything CSS can say fits in it. A stylesheet Tailwind can't read is not saved, and the page says why in Tailwind's own words.

**Site JavaScript** runs on every page. Under it, **Scripts** and **Styles** list the site's other files, which load only where you say, and **Libraries** lists what scripts import. See [Scripts and styles](/design/code).

::: callout {"props":{"tone":"warning","text":"JavaScript here runs on every page of your site. Editing it needs the <strong>Edit Scripts and Stylesheets</strong> permission, marked <strong>Trusted Only</strong>: give it only to people you trust."}}
:::

## For developers

### The files

The styling lives in `content/styling/` next to your content, so it is versioned with the site.

| File | Holds |
|---|---|
| `theme.css` | The stylesheet: Tailwind CSS v4. A site without one uses the stylesheet Lettern starts every site with, until you save |
| `settings.json` | The font faces and the page transition |
| `compiled.css` | What Tailwind made of `theme.css` for the classes the content uses. Generated: never edit it |
| `custom.js`, `scripts/`, `styles/`, `vendor/`, `code.json` | The site's own code, see [Scripts and styles](/design/code) |
| `fonts/` | Self-hosted `.woff2` files |

```css
@import "tailwindcss";
@import "cms";

@theme {
  --color-background: light-dark(#ffffff, #0c0c0b);
  --color-foreground: light-dark(#161614, #f2f2ee);
  --color-primary: #1d4ed8;
  --color-primary-foreground: #ffffff;
  --color-accent: #e11d48;

  --font-sans: "Inter", "Inter Fallback", ui-sans-serif, system-ui, sans-serif;
  --font-display: "Fraunces", "Fraunces Fallback", ui-serif, Georgia, serif;

  --text-5xl: clamp(2.75rem, 2.1rem + 3vw, 5rem);
  --spacing-section: clamp(4rem, 8vw, 8rem);
  --radius-md: 0.625rem;
  --container-content: 72rem;
}

@layer base {
  :root {
    color-scheme: light dark;
  }
  body {
    @apply bg-background font-sans text-base text-foreground;
  }
  h1 {
    @apply font-display text-5xl leading-tight font-semibold text-balance;
  }
  h1 em {
    @apply font-display italic;
  }
}

@utility card {
  @apply rounded-xl border border-border bg-raised p-6 hover:border-accent;
}

@utility btn-primary {
  @apply bg-primary text-primary-foreground hover:opacity-90;
}
```

It starts with two imports: Tailwind, then `cms`, the stylesheet blocks, buttons and form fields are built from. After them it has four kinds of things, and each section of the **Styling** page edits one of them where it stands, so comments and hand-written CSS stay as they are.

### The theme

`@theme` holds the site's values as CSS variables, in Tailwind's namespaces. Every variable is a set of classes: `--color-primary` gives `bg-primary`, `text-primary` and `border-primary`, with any opacity (`bg-primary/20`).

| Variable | Classes | Used for |
|---|---|---|
| `--color-*` | `bg-`, `text-`, `border-`, `ring-`, `fill-`… | Text, fills, borders, shadows |
| `--font-*` | `font-sans`, `font-display` | Font stacks |
| `--text-*` | `text-lg`, `text-5xl` | Font sizes |
| `--leading-*`, `--tracking-*`, `--font-weight-*` | `leading-tight`, `tracking-wide`, `font-semibold` | Line height, letter spacing, font weight |
| `--spacing`, `--spacing-*` | `p-4`, `gap-6`; `px-gutter`, `py-section` | The unit every step of spacing multiplies (0.25rem), and spaces with a name |
| `--radius-*`, `--shadow-*` | `rounded-md`, `shadow-lg` | Corners and shadows |
| `--container-*` | `max-w-content`, `max-w-prose` | Content widths |
| `--breakpoint-*` | `sm:`, `md:`, `lg:`, `xl:`, `2xl:` | The screen sizes responsive classes start at |
| `--ease-*` | `ease-out` | Easing curves, also offered to [animations](/design/animations) by name |
| `--control-*` | — | The sizes of buttons and fields: `sm-height`, `sm-padding`, `sm-text`, and the same for `md` and `lg` |

Blocks, buttons and fields read a few names whatever the site: the colors `background`, `surface`, `raised`, `foreground`, `muted`, `border`, `primary`, `primary-foreground` and `danger`, the containers `prose`, `content` and `wide`, and the spaces `gutter` and `section`. Each has a default until the theme names its own value.

- **Fluid values** are plain CSS: `clamp(1rem, 0.9rem + 0.5vw, 1.25rem)`.
- **Dark mode**: a value with a dark side is `light-dark(#ffffff, #0c0c0b)`, with `:root { color-scheme: light dark; }` in `@layer base`. The dark side applies when the visitor prefers dark, or when the page is switched with the **Light or Dark Mode** action. The `dark:` variant on a class follows the same two.
- Outside a class, a theme value is a CSS variable: `var(--color-primary)`.

### Class rules

A class of the site's own is an `@utility` rule that applies other classes. Blocks carry it like any Tailwind class, with every variant: `card`, `md:card`, `hover:card`.

```css
@utility card {
  @apply rounded-xl border border-border bg-raised p-6 hover:border-accent;
}
```

The site's classes are always in its CSS, whether or not a block uses them.

### Element rules

Rules in `@layer base` set defaults for HTML elements, with `@apply` or plain declarations. Any selector works: `body`, `h1`, `a:hover`, `h1 em`, `li::marker`, `::selection`, `:focus-visible`. They sit in a low CSS layer, so a block's own classes always win.

### Prose

Prose is long-form text: any **Page Content** or **Box** with **Prose** on (`"props": { "prose": true }`; Starter's story templates have it). The element carries the class `cms-prose`, and its blocks are spaced as one flow, whatever they are, a paragraph, an image or a block of your own:

| Variable | Default | Space |
|---|---|---|
| `--prose-blocks` | `1.1em` | Between one block and the next |
| `--prose-headings` | `1.8em` | Before a heading |
| `--prose-after-headings` | `0.6em` | After a heading |
| `--prose-items` | `0.35em` | Between list items |

Set them, and style elements inside prose only, in `@layer components`:

```css
@layer components {
  .cms-prose {
    --prose-blocks: 1.25em;
    --prose-headings: 2.2em;
  }
  .cms-prose h2 {
    @apply mt-10 text-3xl;
  }
}
```

An element's own top margin replaces the space before it. A **Page Content** without a container is part of the flow around it.

### Buttons

A **Button** block's **Style** is a class named `btn-<name>`: every `@utility` rule with that prefix is offered in the menu, and a Button with the style *primary* carries `btn-primary`. The stylesheet a site starts with has `btn-primary`, `btn-secondary`, `btn-ghost` and `btn-link`. States are variants inside the rule: `hover:opacity-90`, `active:scale-95`, `focus-visible:ring-2`.

A variant is a look. A button's height, padding and text size are the control size's (`--control-sm-height`, `--control-md-padding`, `--control-lg-text`… in `@theme`), which fields share. These attributes shape it:

| Attribute | Does |
|---|---|
| `data-size="sm"`, `md`, `lg` | The control size, on the button or anything around it (`--control-height`, `--control-padding`, `--control-text`) |
| `data-icon-only` | A square button, as wide as it is tall; give it an `aria-label` |
| `data-shape="round"` | A circle, or with a label a pill |

For your own markup, a button is `class="cms-button btn-primary"`.

### Field variables

Everything a form field looks like is a `--field-*` CSS variable that one stylesheet reads for every kind of field. Set the ones you want to change in `@layer base`, on `:root` and on `[data-theme]`, so they hold in a section with its own color mode too:

```css
@layer base {
  :root,
  [data-theme] {
    --field-radius: 0;
    --field-focus-border-color: var(--color-accent);
    --field-label-font-weight: var(--font-weight-semibold);
    --field-checkbox-checked: var(--color-accent);
  }
}
```

| Part | Variables, after `--field-` |
|---|---|
| All fields | `background`, `border-width`, `border-color`, `radius`, `color`, `placeholder`, `shadow` |
| States | `hover-background`, `hover-border-color`, `focus-background`, `focus-border-color`, `focus-ring-width`, `focus-ring-color`, `invalid-color`, `invalid-ring-color`, `disabled-opacity`, `disabled-background` |
| Labels and help | `label-font-size`, `label-font-weight`, `label-color`, `label-required`, `help-font-size`, `help-color` |
| Spacing | `spacing-fields`, `spacing-label`, `spacing-list`, `spacing-choice` |
| Dropdowns, text areas | `select-arrow-color`, `select-arrow-size`, `textarea-min-height`, `textarea-resize` |
| Checkboxes | `checkbox-size`, `checkbox-radius`, `checkbox-background`, `checkbox-border-color`, `checkbox-checked`, `checkbox-mark-color`, `checkbox-mark-size`, `checkbox-mark-icon`, `checkbox-dash-icon` |
| Radio buttons | `radio-size`, `radio-checked`, `radio-dot-color`, `radio-dot-size`, `radio-on-background`, `radio-on-dot` |
| Switches | `switch-width`, `switch-height`, `switch-radius`, `switch-off`, `switch-on`, `switch-knob`, `switch-inset`, `switch-knob-shadow` |
| Sliders | `slider-track-height`, `slider-track`, `slider-fill`, `slider-radius`, `slider-thumb-size`, `slider-thumb`, `slider-thumb-border`, `slider-thumb-shadow` |
| Tag fields, chips, file pickers | `tags-background`, `tags-color`, `tags-radius`, `chips-radius`, `chips-background`, `chips-border-color`, `chips-selected`, `chips-selected-text`, `file-background`, `file-color`, `file-radius` |

Radio buttons, switches and sliders take the checkbox's checked color until you give them their own. How big a field is comes from the `--control-*` values, like a button's.

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

### Compiled CSS

Pages link one stylesheet, compiled by Tailwind itself from `theme.css` for exactly the classes the content uses: every `class` a block carries and every class attribute in HTML somebody wrote. It is kept as `content/styling/compiled.css`, which says what it was compiled from, so Lettern knows whether it is current. Commit it with the rest: a site deployed from git has its CSS without compiling anything.

It is compiled again whenever the stylesheet or the content changes:

- **In the admin's browser.** Whenever the admin is open and the CSS is behind, it compiles it and hands it back. A server needs no Node.
- **On the server**, where it has Node 20 or newer, right when something is saved. `CMS_NODE` names the binary when it is not `node` on the `PATH`.
- **`php cms build`** compiles first when the machine has Node. Where it has none, the build warns that the CSS is older than the content, and the admin compiles it the next time it is open.

`styling/get` returns `current`: whether the published CSS is up to date.

### Fonts

Font files live in `content/styling/fonts/` and are served from `/_cms/fonts/`, with `preload` for the ones the first screen needs. `settings.json` lists the faces under `fonts`, and the theme names the family: `--font-sans: "Inter", "Inter Fallback", sans-serif`.

**Add a Google Font…** in a font's picker under **Typography → Fonts** downloads the latin files and adds them to `fonts`. It takes what the family really has: a variable family is one file for the weights its axis spans (EB Garamond is 400 to 800, not 100 to 900), a static family the weights it has, and no file is saved twice. Agents use `styling/fonts-import` for that, with `style` (`normal`, `italic` or `both`) and, for a static family, `weights`, and `styling/fonts-upload` to upload one (the file as base64, a family, a weight such as `400` or `100 900`, and a style).

A font face names what is drawn until it arrives, so text doesn't move when the font loads: `fallback`, a local font such as Arial, with `sizeAdjust`, `ascentOverride`, `descentOverride` and `lineGapOverride`. **Add a Google Font…** and `styling/fonts-import` fill these in from the font's own tables: Arial, Times New Roman or Courier New, at the size and line height that match. Change one only to correct it; what you set stays when the family is imported again.

```json
{ "family": "Inter Tight", "src": "fonts/inter-tight-100-900.woff2", "weight": "100 900", "style": "normal", "preload": true, "fallback": "Arial", "sizeAdjust": "102%", "ascentOverride": "98%", "descentOverride": "26%", "lineGapOverride": "0%" }
```

That stand-in is the family `"Inter Tight Fallback"`: name it after the font in the theme's stack.

### Page transition

`transition` in `settings.json` uses the browser's View Transitions: `type` is `fade`, `slide`, `scale` or `none`, with a `duration` in seconds. It works on the static site with no JavaScript, and is skipped for visitors who prefer reduced motion. `navigation` is `document` (the default) or `client`: see [Navigation without page loads](/design/page-navigation).

```json
{ "fonts": [], "transition": { "type": "fade", "duration": 0.25, "navigation": "document" } }
```

### Custom JavaScript

`content/styling/custom.js` loads as an ES module on every page. Use it to register Alpine components for behavior the builder can't express: listen for `cms:alpine` on `document` (its `detail` is Alpine), then give an element that component under **Interact → Code Component** (`logic.component`).

```javascript
document.addEventListener('cms:alpine', (e) => {
  e.detail.data('pricing', () => ({
    yearly: false,
    get price() { return this.yearly ? 190 : 19 },
  }))
})
```

It is edited under **Code** or with the `styling-code/set-custom` ability, and needs the `site.code` permission. There is no separate file for custom CSS: it goes in `theme.css`. Scripts and stylesheets that load only on some pages, and the libraries they import, are on [Scripts and styles](/design/code).

### Abilities

`styling/get` returns the stylesheet (`css`), the names of the site's classes, the fonts and font files, the transition, `custom.js`, the templates entries can use, the published stylesheet's address and `current`; the `cms://site/styling` context resource holds the stylesheet with the rules for using it. `styling/update` replaces the whole stylesheet (`{"css": "…"}`): read it, change it and send all of it back. A stylesheet Tailwind can't compile is refused with Tailwind's message, and nothing is saved. It also replaces `fonts` and merges `transition`, one setting at a time.
