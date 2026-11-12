---
id: 01m75f2pwez59agde4m72jrybz
title: Block behaviors
position: 8
description: 'Attach a script of your own to one block: it starts when the block is on the page and stops when it leaves.'
---
A block behavior is a script that belongs to one element. The block names a script of the design, the site calls it when the element is in the page, and calls it again to clean up when the element leaves. This is where GSAP, Three.js or any other library attaches to a page.

It is for what [animations](/design/animations) and [interactions](/design/interactions) can't say. Try those first: they need no code and no trusted permission.

## Put a script on a block

1. Write the script as `content/design/scripts/<name>.js`. See [Scripts and styles](/design/code).
2. Select the block and open **Interact**.
3. Under **Behaviors**, choose the **Script** and when it **Runs**. **Add Option** gives it a named value, like `max` = `8`.

| Runs | The script is fetched and started |
|---|---|
| **On Load** | With the page |
| **In View** | A screen before the element is seen |
| **When Idle** | Once the browser has nothing else to do |
| **When Loaded** | After the page's load event and its fonts: for a script that measures text or layout |

The same panel lists the scripts and styles the block loads. Putting a script, a style, a behavior or a persist name on a block needs the **Edit Custom CSS and JavaScript** permission, in the admin and through every ability. Without it, a block keeps what it has.

Scripts don't run in the editor on their own: there the block is only its design. A block that a behavior draws, such as a canvas or a chart, would be a blank there, so while it is empty it says which behavior draws it and that the preview shows it. Give such a block a size in **Design**, so the editor shows its place.

A behavior that can draw in the editor too says so, and then the editor shows it there as on the site: see [Draw in the editor](#draw-in-the-editor).

## Write the script

A behavior is an ES module that exports `mount`:

```javascript
// content/design/scripts/tilt.js
export function mount(el, props, { token, reducedMotion, signal }) {
  if (reducedMotion) return

  // Props come from whoever edits the page: take a number, within a range.
  const max = Math.min(Math.max(Number(props.max) || 8, 0), 30)

  el.addEventListener('pointermove', (event) => {
    const box = el.getBoundingClientRect()
    const x = (event.clientX - box.left) / box.width - 0.5
    el.style.transform = `perspective(600px) rotateY(${x * max}deg)`
  }, { signal })

  return () => {
    el.style.transform = ''
  }
}
```

| Argument | Is |
|---|---|
| `el` | The block's element |
| `props` | The block's **Options**, as an object. Empty when it has none |
| `token(path)` | A design token's value where the element is: `token('color.primary')`, `token('duration.fast')`. An empty string when there is none |
| `reducedMotion` | `true` when the visitor's system asks for less motion, or when they paused motion with the page's **Motion Toggle** block. When that changes, the behavior is unmounted and mounted again |
| `signal` | An `AbortSignal` that aborts when the element leaves. Pass it to `addEventListener` and `fetch`, and there is nothing left to undo |

What `mount` returns is called when the element leaves the page. A module can also export `unmount(el)`, which runs after it. `mount` may be `async`, and a module's default export works in its place.

The element can arrive and leave in three ways, and the contract is the same for each: the page loads, a script adds or removes markup, or [navigation without page loads](/design/page-navigation) swaps the page. An element that is [persisted](/design/page-navigation#keep-an-element-across-pages) across pages stays mounted.

An error in a behavior is logged to the console and stops only that behavior.

## Draw in the editor

A script that exports `canvas` as `true` is mounted in the editor's canvas as well, so the page being edited shows what it draws: a WebGL scene, a chart, a pattern. It gets the same `mount(el, props, context)`, cleanup and `unmount(el)` as on the site. Every edit renders the canvas again: the behavior is undone first and mounted afresh after, and undone when the editor closes.

```javascript
// content/design/scripts/plate.js
export const canvas = true

export function mount(el, props, { token, signal, window: win = window, document: doc = document }) {
  const plate = doc.createElement('canvas')
  el.append(plate)
  // … draw, reading win.devicePixelRatio and win.matchMedia() for the page it is on
  return () => plate.remove()
}
```

In the editor the script runs in the admin while its element is in the canvas, so the context carries two more values. Read the size, the scroll and media queries from them, not from the globals: there a script's own `window` and `document` are the admin's page, never the canvas. The script works in both places when it reads them from the context:

| Argument | Is |
|---|---|
| `canvas` | `true` in the editor, absent on the site |
| `window`, `document` | The window and document the element is in: the canvas's in the editor |

Only scripts the site publishes itself are run there, and the admin borrows just the names in the page's import map that the script imports. Because such a script runs in the admin as whoever opens the editor, writing it needs **Edit Custom CSS and JavaScript**, an administrator's permission: see [Security](/operations/security#give-each-person-only-what-they-need).

A behavior that moves by itself is best still in the editor, as for `reducedMotion`: the page is what moves there. The canvas runs no scripts of its own, and a page like that never shows what a `<canvas>` draws, so the editor shows a picture of each canvas the behavior draws in its place, taken after it mounts, as it settles and when the block changes size. Without the export a behavior keeps its name in the editor, and so does one in a browser that cannot load it there.

A script that is not a behavior hears the Motion Toggle too: pausing sets `<html data-cms-motion="paused">` and dispatches `cms:motion` on `document`, with `event.detail.paused`.

::: callout {"props":{"tone":"warning","text":"<strong>Props are untrusted.</strong> Anyone who can edit the page writes them, not the script's author. Read them as numbers, booleans or text. Never use one as HTML (<code>innerHTML</code>), as code, or as an address to load without checking it."}}
:::

## For developers

### How it is stored

```json
{
  "type": "section",
  "behavior": { "module": "tilt", "props": { "max": 8 }, "when": "visible" },
  "code": { "styles": ["tilt"] }
}
```

- `module` is a script of the design by name: `tilt`, `lib/tilt`.
- `props` is a plain object of text, numbers, booleans, `null`, lists and objects, up to 4000 characters as JSON. Text in it can name data like any text in a block: `"{props.speed}"` inside a component, `"{entry.title}"` on a page.
- `when` is `visible`, `idle` or `loaded`. Leave it out to run with the page.
- `code` loads other scripts and styles of the design with the block.

The built page carries them as attributes, which the site's runtime reads:

```html
<section data-cms-behavior="/_cms/site/scripts/tilt-1a2b3c4d5e.js" data-cms-props="{&quot;max&quot;:8}" data-cms-when="visible">
```

A block can carry several behaviors: `behavior` then takes a list, and each is mounted and undone by itself.

```json
{ "behavior": [{ "module": "tilt" }, { "module": "cue", "props": { "at": 0.5 } }] }
```

They start in the order written and finish loading in whichever order their scripts arrive, so one must not count on another having mounted. On the page, `data-cms-behavior` then holds the list as JSON, each with its `src`, `props` and `when`.

A behavior whose script doesn't exist is left out of the page.

The context resource `cms://blocks` tells an agent the same rules, and `design-code/list` names the scripts it can use.
