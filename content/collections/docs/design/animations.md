---
id: 01m5x9jmrth1ggeatmbzxcz7vk
title: Animations
position: 6
group: 'Data and behaviour'
description: Fade in as things appear, follow the scroll, react to hover, split headings into words — and build timelines across elements. As CSS and Web Animations, with no script where none is needed.
---
Select a block, open **Interact** and press **+** next to **Animations**. Pick a preset — *Fade up*, *Words rise*, *Parallax*, *Lift*, *Float*… — or start from scratch. Everything stays editable, and **▶** opens the rendered-site preview.

## Triggers

| Trigger | Plays |
|---|---|
| **Appear** | Once when the element scrolls into view — *A little into view* by default. Turn on **Reverse when scrolled back** to replay it. |
| **Scroll** | Follows the scroll position between a start and an end point. To hold something in place while it plays, give it `position: sticky` in a taller parent and let the animation watch that parent. |
| **Hover** | On hover and keyboard focus; reverses when the pointer leaves. |
| **Press** | While pressed. |
| **Page load** | As the page paints. |
| **Loop** | A few times, stopping within 5 seconds, optionally back and forth. Set to repeat forever, the page needs a **Motion Toggle** block so visitors can pause it, and the build warns when it has none. |
| **On event** | When a [Play animation](/design/interactions#actions) action plays it — menus, modals, tabs. |

Appear and Scroll can **watch** another element: the animation plays when that one comes into view. **Plays on** limits an animation to desktop, tablet or phone; for different motion per screen, add two animations.

## What runs where

Page load, Scroll and Loop are plain CSS: no script, so they can't hold back the first paint, and with CSS off the content is simply there. Appear, Hover, Press and On event use the Web Animations API through a small script that loads only on pages using them. If it never runs, everything shows as designed.

A page load animation decides when the page looks done, so Lettern keeps it short: its delay stops at 0.2 seconds and its last item starts by 0.3 seconds, however long the stagger you set. Appear skips anything already on screen when the page opens. A browser without scroll-driven animations shows the design in its final state.

## Steps

An animation is a timeline of one or more steps. Each step animates a **target** from one state to another:

| Target | Animates |
|---|---|
| This element | Itself |
| Each child, in turn | Its children, staggered |
| Each word | The text, split into words in the HTML itself, so it stays real text for readers and search. **Rise from behind a line** clips each word, so it slides up from behind an edge |
| Another element | Any element on the page |

**From** is how it starts; **To** is how it ends. Leave a side empty to use the element's own design — *from* `opacity: 0, y: 32` fades and slides it into place. Properties: opacity, move (x, y, in px or %), scale, rotate (also in 3D), skew, blur, brightness, grayscale, clip path, colors, radius, shadow, width, height, letter spacing, origin and perspective. Colors take tokens.

Each step has a **duration**, a **delay**, a **stagger** between items, an **ease** (smooth out, expo, overshoot, elastic, bounce, linear… or any `cubic-bezier()`), and with several steps an **at** time; without one a step starts when the previous one ends. The bars above the steps show the timeline.

## A timeline that loops

To tell a short story that repeats, like a product demo, add every moment as a step of one **Appear** animation with **Repeat** set to forever and a **rest** at the end. Give each step a target and a start time, and the steps play as one timeline: it starts when the element comes into view, pauses when it leaves, and between steps each target stays where the last step left it. Give a target several steps to bring it in and take it out again, and fade the whole stage out at the end, so the restart doesn't show.

The element's own styles are the finished state, so they should show the story's end: that is what visitors see with reduced motion or with scripts off. The page needs a **Motion Toggle** block, like anything that runs forever. Words and children can't be part of such a timeline: target elements.

```json
{ "id": "demo", "trigger": { "type": "appear" }, "repeat": -1, "hold": 3, "steps": [
  { "target": "#prompt", "from": { "clipPath": "inset(0 100% 0 0)" }, "to": { "clipPath": "inset(0 0 0 0)" }, "at": 0.5, "duration": 1.5, "ease": "steps(30)" },
  { "target": "#answer", "from": { "opacity": 0 }, "at": 2.5, "duration": 0.4 }
] }
```

## Accessibility

Visitors who ask for reduced motion get the finished design: appear, load, scroll and loop animations don't run, and hover, press and event animations jump to their end. Content is never hidden waiting for a script, and printing shows everything. An element with `overflow: hidden` becomes the scroller for a scroll animation inside it; use `overflow: clip` instead.

## How it is stored

A block's `motion` is a list of animations:

```json
[
  { "id": "m1", "name": "Words rise", "trigger": { "type": "appear", "start": "top 85%", "once": true },
    "steps": [{ "target": "words", "from": { "opacity": 0, "y": 20 }, "duration": 0.7, "ease": "power3.out", "stagger": 0.04 }] },
  { "id": "m2", "trigger": { "type": "scroll", "start": "top bottom", "end": "bottom top" },
    "steps": [{ "target": "self", "from": { "yPercent": -12 }, "to": { "yPercent": 12 }, "ease": "none" }] },
  { "id": "open", "trigger": { "type": "event" },
    "steps": [
      { "target": "self", "from": { "xPercent": 100 }, "duration": 0.5, "ease": "expo.out" },
      { "target": "children", "from": { "opacity": 0, "x": 24 }, "duration": 0.4, "stagger": 0.05 }
    ] }
]
```

- `trigger.type`: `appear`, `scroll`, `hover`, `press`, `load`, `loop`, `event`; `start`/`end` read `<element edge> <viewport position>`, with `top`, `center` or `bottom` for the edge and those or a percentage for the position (`top 80%`, `center center`); `node` (`#<block id>`) watches another element.
- `on`: `desktop`, `tablet`, `mobile`; absent means every screen.
- `steps[].target`: `self`, `children`, `words` or `#<block id>`; `steps[].mask` clips each word.
- `steps[].ease`: a name (`expo.out`, `power3.inOut`, `sine.inOut`, `back.out`, `elastic.out`, `bounce.out`, `linear`…), or `cubic-bezier()`, `linear()` or `steps()` as written.
- `repeat` (`-1` forever) and `yoyo` repeat each step; with `hold` (seconds) on an appear animation they repeat the [whole timeline](#a-timeline-that-loops).

A play action names the block and the animation id: `{ "do": "play", "node": "b9x2k4", "motion": "open", "mode": "toggle" }`.
