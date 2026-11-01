---
id: 01m5x92hk2a210v3pxvc1vx998
title: Interactions
position: 5
group: 'Data and behaviour'
description: Menus, tabs, modals, filters and "load more" — built from state, events and actions in the inspector, and run by Alpine.js on the site.
---
Select a block and open **Interact**. Below the animations are the block's scripts: **State**, **Events**, **Show and states**, **Behaviors** and, for links and forms, **Load into**. On the site they run on [Alpine.js](https://alpinejs.dev) — its CSP build, which never evaluates free-form JavaScript — plus [Alpine AJAX](https://alpine-ajax.js.org). Pages without interactions load no JavaScript at all.

A mobile menu, start to finish:

```json
{
  "type": "box", "props": { "tag": "header" },
  "logic": {
    "data": { "open": false },
    "states": { "open": "open" },
    "on": [{ "event": "keydown", "key": "escape", "mods": ["window"], "actions": [{ "do": "set", "var": "open", "value": "false" }] }]
  },
  "children": [
    { "type": "box", "props": { "tag": "button" }, "attrs": { "aria-label": "Menu" },
      "logic": { "attrs": { "aria-expanded": "open" }, "on": [{ "event": "click", "actions": [{ "do": "toggle", "var": "open" }] }] },
      "children": [{ "type": "icon", "props": { "icon": "list" } }] },
    { "type": "box", "props": { "tag": "nav" }, "logic": { "show": "open", "transition": "collapse" }, "children": [] }
  ]
}
```

## State

Variables the element and everything inside it can read and change: `open: false`, `tab: 'overview'`, `count: 0`. Values are true/false, numbers, quoted text or JSON lists and objects.

## Events

Each event runs a list of actions in order.

| Event | When |
|---|---|
| Click, Pointer enters, Pointer leaves | The usual |
| Gets focus, Loses focus | Keyboard and pointer focus |
| Typing (input), Value changes, Form submit | Inputs and forms |
| Key pressed | With a key: `escape`, `enter`, `k`, `meta.k`… |
| Scrolls into view, Scrolls out of view | The element enters or leaves the screen |
| Page scrolls, Window resizes | On the whole window |
| Page loads | When the element starts |

Options (the sliders icon): **Prevent default**, **Stop propagation**, **Outside this element** (close a menu on an outside click), **Anywhere on the page**, **Only once**, **On this element only**, **Debounce**.

### Actions

| Action | Does |
|---|---|
| Set state | `open` to `false`, `tab` to `'pricing'`, `count` to `count + 1` |
| Toggle state | Flips a true/false variable |
| Add to number | Adds (or subtracts) from a number |
| If … then … else | Runs one list or the other, by a condition |
| Play animation | Plays, reverses, toggles or restarts an element's [animation](/design/animations) with the *On event* trigger |
| Scroll to | The top, the bottom, an `#anchor` or an element, with an offset for sticky headers |
| Load page part (AJAX) | Fetches a URL and swaps in the elements with the same identity from it |
| Copy to clipboard | A value, or an element's text |
| Go to URL | Navigates, optionally in a new tab |
| Light / dark mode | Switch, light, dark or system — remembered across visits |
| Focus element | Moves keyboard focus |
| Lock page scrolling | For modals and full-screen menus |
| Wait | Pauses before the next action |
| Send event | Dispatches a custom event other elements can listen for |
| Expression | An Alpine expression, for anything else |

Expressions are Alpine's: `open`, `!open`, `tab === 'a'`, `count > 3 && ready`, `query.length`. The CSP build has no access to `window`, `document` or other globals and no arrow functions, so editors can't run arbitrary code — developers add JavaScript in [custom.js](/design/design-system#custom-css-and-javascript).

## Show and states

- **Show when** — the element is shown only while the expression is true, with an optional **Fade**, **Scale** or **Collapse** transition. Use **Outline** to select and edit a block even when its visibility condition hides it in the rendered page.
- **States** — `is-<name>` while an expression is true. Style the state in **Design**, and its children with `in-<name>` — see [Styles](/design/styles#custom-states).
- **Text** — replace the element's text with a value, like `count`.
- **Attributes** — keep `aria-expanded`, `aria-selected`, `hidden`, `disabled`, `href`… in sync with state.
- **Input value** — on an **Input** block, keeps a variable in sync with what is typed: build live filters and calculators.

## Behaviors

Ready-made interactions you switch on:

| Behavior | Does |
|---|---|
| Scroll states | Adds `is-scrolled` after the page scrolls past a threshold, and optionally `is-hidden` while scrolling down — headers that shrink or hide |
| Scroll spy | In-page links inside (`#section`) get `is-current` and `aria-current` while their section is in view — tables of contents |
| Hover group | Children can style the `group-hover` state: they react when the whole element is hovered |
| Menu | A navigation menu with one panel that moves between items. Each child is a link or button, with an optional panel as its second element. A pill follows the pointer and keyboard focus, the panel's background changes shape to fit the next item, and its content cross-fades. Escape closes it, the Down arrow goes into it, and it respects reduced motion |
| Marquee | The children scroll sideways in an endless loop, at a speed in pixels per second, optionally reversed and paused on hover |
| Carousel | A row to step through. The first child scrolls sideways (give it overflow and scroll snap in **Design**), and the first two buttons after it go back and forward by one item. A button is disabled at its end of the row. Elements with a `data-carousel-to` attribute are thumbnails: each goes to the item in its own position, and has `data-current` while that item shows |

## Load into

Links and forms can load the next page in the background and swap only some elements — **Load more**, filters, tabs with real URLs — without a full reload. Choose the elements to update; on each of those, **When loaded** decides how new content arrives: replace it, replace what is inside, add to the end or start, or morph. **Update the address bar** keeps the URL shareable. Without JavaScript the link simply opens the page.

A "Load more" button under a paginated blog list: a **Link** bound to `pagination.next`, loading into the Repeat, with the Repeat's **When loaded** set to *Add to the end*.

## Tabs

For tabs, use the **Tabs** block instead of wiring up state: add a **Tab** per panel, and put anything in it. **Look** chooses underlined tabs, a segmented control, or a column of tabs beside the panels, which becomes a row on a phone. It follows the [ARIA tabs pattern](https://www.w3.org/WAI/ARIA/apg/patterns/tabs/), with arrow keys, Home and End. Find in page opens the panel it finds something in, and so does a link to something inside one. Without JavaScript every panel shows, one after the other, under its label. On the canvas all panels show, so each can be selected.

## Code components

When something can't be built from state, events and actions — a calculator, a chart, a third-party widget — write an Alpine component in the site's custom JavaScript (**Design system → Code**, see [Design system](/design/design-system#custom-css-and-javascript)) and name it under **Interact → Code component**. The element then uses that component instead of its own **State**; everything inside can read its values and call its methods, and the other interaction settings keep working.

## How it is stored

A block's `logic`:

```json
{
  "data": { "tab": "monthly" },
  "on": [{ "event": "click", "mods": ["prevent"], "actions": [
    { "do": "set", "var": "tab", "value": "'yearly'" },
    { "do": "if", "test": "tab === 'yearly'", "then": [{ "do": "play", "node": "b9x2k4", "motion": "m1", "mode": "restart" }], "else": [] }
  ] }],
  "show": "tab === 'yearly'", "transition": "fade",
  "states": { "active": "tab === 'yearly'" },
  "text": "count",
  "attrs": { "aria-pressed": "tab === 'yearly'" },
  "model": "query",
  "target": ["b4m1q8"], "push": true, "merge": "append",
  "behaviors": { "scroll": { "threshold": 40, "hide": true }, "spy": { "offset": 96 }, "group": true, "carousel": {}, "marquee": { "speed": 60 } }
}
```

Action types are `set`, `toggle`, `add`, `if`, `wait`, `play`, `scroll`, `copy`, `go`, `theme`, `focus`, `dispatch`, `fetch`, `lock` and `run`. Lettern checks every value when it is saved; `blocks/types` lists the events, options, actions and transitions for agents.
