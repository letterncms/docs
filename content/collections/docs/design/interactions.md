---
id: 01m5x92hk2a210v3pxvc1vx998
title: Interactions
position: 5
description: Menus that open, buttons that react, lists that load more. Build them in a block's Interact tab, without writing code.
---
Interactions make your pages respond to visitors: a menu that opens on a phone, a header that shrinks as you scroll, a "Load more" button under a blog list. You build them in a block's **Interact** tab, under its animations.

![A heading selected on the home page, with its Interact settings open on the right.](/media/screens/design-interact.webp)

Pages without interactions load no JavaScript at all.

## How it works

An interaction has three parts. **State** remembers something, like whether the menu is open. **Events** change it, like a click on the menu button. And blocks react to it: the menu shows while it's open.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A click on the menu button toggles the open state, and the menu shows while open is true.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Event</b><span class=\"docs-card__field\">Click</span></div><b>Something happens</b><small>On the menu button</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>State</b><span class=\"docs-card__field\">open = true</span></div><b>Something changes</b><small>Remembered by the header</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Show when</b><span class=\"docs-card__field\">open</span></div><b>Blocks react</b><small>The menu appears</small></div></div></figure>"}}
:::

## Build a mobile menu

Here's the whole thing, start to finish. You need a header that holds a menu button and the menu itself.

1. **Remember whether it's open.** Select the header, open **Interact**, and under **State** press **Add Variable**. Name it `open`, with the value `false`.
2. **Open and close it.** Select the menu button. Under **Events**, press **Add Event** and keep **Click**. Press **Add Action** and choose **Toggle State**, then the variable `open`.
3. **Show the menu while it's open.** Select the menu. Under **Bindings**, set **Show When** to `open`, and pick the **Collapse** transition.
4. **Close it with Escape.** Select the header again and add an event: **Key Pressed**, with the key `escape`. In its options, choose **Anywhere on the Page**. Add the action **Set State**: `open` to `false`.
5. **Tell screen readers.** On the menu button, under **Bindings → Attributes**, press **Bind Attribute** and set `aria-expanded` to `open`.

Choose **Preview** in **More Actions**, the **⋯** at the top of the editor, to try it.

::: callout {"props":{"tone":"tip","text":"To restyle the header while the menu is open, add a state under <strong>Bindings → States</strong>: <code>open</code> when <code>open</code>. Then style it in <strong>Design</strong>. See <a href=\"/design/styles#custom-states\">Custom states</a>."}}
:::

## State

Variables that a block and everything inside it can read and change: `open` set to `false`, `tab` to `'overview'`, `count` to `0`. Values are true or false, numbers, quoted text, or JSON lists and objects.

Put the variable on the block that holds everything that needs it, like the header for a mobile menu.

## Events

An event runs a list of actions, one after the other, when something happens.

| Event | When |
|---|---|
| **Click**, **Pointer Enters**, **Pointer Leaves** | The pointer clicks, or moves over or off the block |
| **Gets Focus**, **Loses Focus** | Keyboard or pointer focus arrives or leaves |
| **Typing**, **Value Changes**, **Form Submit** | In inputs and forms |
| **Key Pressed** | A key, like `escape`, `enter`, `k` or `meta.k` |
| **Scrolls into View**, **Scrolls Out of View** | The block enters or leaves the screen |
| **Page Scrolls**, **Window Resizes** | On the whole window |
| **Page Loads** | When the block starts |

The options of an event (the sliders icon) fine-tune it: **Prevent Default**, **Stop Propagation**, **Outside This Element** (to close a menu when visitors click elsewhere), **Anywhere on the Page**, **Only Once**, **On This Element Only** and **Debounce**.

### Actions

| Action | Does |
|---|---|
| **Set State** | Sets a variable: `open` to `false`, `tab` to `'pricing'`, `count` to `count + 1` |
| **Toggle State** | Flips a true or false variable |
| **Add to Number** | Adds to (or subtracts from) a number |
| **If … Then … Else** | Runs one list of actions or another, depending on a condition |
| **Play Animation** | Plays, reverses, toggles or restarts a block's [animation](/design/animations) with the **On Event** trigger |
| **Scroll To** | The top or bottom of the page, a section or a block, with an offset for sticky headers |
| **Load Page Part** | Fetches a page and swaps in the blocks you choose from it |
| **Copy to Clipboard** | A value, or a block's text |
| **Go to Link** | Opens a link, optionally in a new tab |
| **Light or Dark Mode** | Switches, or sets light, dark or the system's choice. Remembered across visits |
| **Focus Element** | Moves keyboard focus to a block |
| **Lock Page Scrolling** | Stops the page scrolling behind a modal or a full-screen menu, or lets it scroll again |
| **Wait** | Pauses before the next action |
| **Send Event** | Sends a named event that other blocks can listen for |
| **Expression** | Anything else, written as an expression |

Conditions and values are short expressions: `open`, `!open`, `tab === 'a'`, `count > 3 && ready`, `query.length`.

## Bindings

Under **Bindings**, a block reacts to its variables:

- **Show When** shows the block only while a condition is true, with an optional **Fade**, **Scale** or **Collapse** transition. To select a block it hides, use the **Outline** in the sidebar.
- **States** add a custom state while a condition is true, like `open`. Style it in **Design**, and style children with **in open**: see [Custom states](/design/styles#custom-states).
- **Text** replaces the block's text with a value, like `count`.
- **Attributes** keep `aria-expanded`, `aria-selected`, `hidden`, `disabled`, `href` and others in sync with a variable.
- **Input Value**, on an **Input** block, keeps a variable in sync with what visitors type. Use it for live filters and calculators.

## Behaviors

Ready-made interactions you switch on under **Behaviors**:

| Behavior | Does |
|---|---|
| **Scroll States** | Gives the block the state *scrolled* once the page scrolls past a distance you set, and optionally *hidden* while scrolling down. For headers that shrink or hide |
| **Scroll Spy** | Links inside to `#sections` get the state *current* while their section is in view. For tables of contents |
| **Hover Group** | Blocks inside can react when the whole block is hovered, with the **Hover on Hover Group** state |
| **Menu** | A navigation menu with one panel that moves between items. Each child is a link or button, with an optional panel after it. A pill follows the pointer and keyboard focus, the panel's background changes shape to fit the next item, and its content cross-fades. Escape closes it, the Down arrow goes into it, and it respects reduced motion |
| **Marquee** | The children scroll sideways in an endless loop, at a **Speed** in pixels per second, optionally reversed and paused on hover |
| **Carousel** | A row to step through. The first child scrolls sideways (give it overflow and scroll snap in **Design**), and the first two buttons after it go back and forward by one item. A button is disabled at its end of the row. Blocks with a `data-carousel-to` attribute are thumbnails: each goes to the item in its own position, and has `data-current` while that item shows |

## Load more without a reload

Links, buttons and forms can load the next page in the background and swap in only some blocks, without a full reload. Use it for **Load more** buttons, filters, and tabs with their own links.

1. Select the link or button, and open **Load Into** in its **Interact** tab.
2. Under **Update**, add the blocks to swap.
3. Turn on **Update the Address Bar** to keep the link shareable.
4. On each block you swap, **When Loaded** in the same section decides how the new content arrives: **Replace It** (the default), **Replace What Is Inside**, **Add to the End**, **Add to the Start** or **Morph (Keep State)**.

A "Load more" button under a paginated blog list is a **Link** connected to **Next Page of a List**, loading into the Repeat, with the Repeat set to add to the end. **Load Into** shows on links, buttons and boxes, so a Repeat's setting is stored as `"merge": "append"` in its `logic`: ask the [assistant](/agents/assistant) to set it, or see [For developers](#all-logic-settings). Without JavaScript, the link simply opens the next page.

## Tabs

For tabs, use the **Tabs** block instead of building them from state. Add a **Tab** per panel, and put anything in it. **Look** chooses underlined tabs, a segmented control, or a column of tabs beside the panels, which becomes a row on a phone.

Tabs follow the [ARIA tabs pattern](https://www.w3.org/WAI/ARIA/apg/patterns/tabs/), with arrow keys, Home and End. Find in page opens the panel it finds something in, and so does a link to something inside one. Without JavaScript every panel shows, one after the other, under its label. In the editor all panels show, so you can select each one.

## Code components

When something can't be built from state, events and actions, like a calculator, a chart or a third-party widget, a developer can write it as a small component in the site's custom JavaScript. Name it under **Interact → Code Component**. The block then uses that component instead of its own **State**; everything inside can read its values and call its functions, and the other interaction settings keep working. See [Custom CSS and JavaScript](/design/design-system#custom-css-and-javascript).

A script that works on the element itself, with a library like GSAP or Three.js, is a [block behavior](/design/behaviors) instead.

## For developers

### What runs on the site

Interactions run on [Alpine.js](https://alpinejs.dev), in its CSP build, which never evaluates free-form JavaScript, plus [Alpine AJAX](https://alpine-ajax.js.org) for **Load Into** and **Load Page Part**. Expressions are Alpine's; the CSP build has no access to `window`, `document` or other globals and no arrow functions, so editors can't run arbitrary code. Developers add JavaScript in `custom.js`.

### The mobile menu, as stored

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

### Naming another block in an attribute

An attribute that points at another element takes that block's id with a `#`:

```json
{ "type": "box", "props": { "tag": "section" }, "attrs": { "aria-labelledby": "#hero-title" } }
```

On the page it becomes the id that block has: its anchor, a heading's own, or one made for it. It works in `aria-labelledby`, `aria-describedby`, `aria-controls`, `aria-owns`, `aria-details`, `aria-flowto`, `aria-activedescendant`, `aria-errormessage` and `for`. The build warns when the block named is not on the page. A plain word, without `#`, is an id you wrote yourself and stays as it is.

### All logic settings

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

- Events: `click`, `mouseenter`, `mouseleave`, `focus`, `blur`, `input`, `change`, `submit`, `keydown` (with `key`), `enter`, `leave`, `scroll`, `resize`; **Page Loads** is stored as `init`, a list of actions.
- Event options (`mods`): `prevent`, `stop`, `outside`, `window`, `once`, `self`, `debounce`.
- Action types: `set`, `toggle`, `add`, `if`, `wait`, `play`, `scroll`, `copy`, `go`, `theme`, `focus`, `dispatch`, `fetch`, `lock` and `run`.
- `states` add `is-<name>`; `model` is **Input Value**; `target`, `push` and `merge` are **Load Into**; `component` names a code component.

Lettern checks every value when it is saved; `blocks/types` lists the events, options, actions and transitions for agents.
