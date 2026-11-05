---
id: 01m5x9jmrth1ggeatmbzxcz7vk
title: Animations
position: 6
description: Fade things in as they appear, follow the scroll, react to hover. Pick a preset, then make it your own.
---
Animations bring a page to life: a heading that rises word by word, a photo that drifts as you scroll, a card that lifts when you point at it. Add them to any block, in its **Interact** tab.

They're light, too. Many run as plain CSS with no script at all, and visitors who prefer less motion get your finished design.

## Add an animation

1. Select a block and open **Interact**.
2. Press **+** next to **Animations** and pick a preset, like **Fade Up** or **Words Rise**. Or choose **Custom Animation** to start from scratch.
3. Press the play button, **Preview Animation**, to watch it on the page.

Everything a preset sets stays editable: change its trigger, its timing or what it moves.

| Presets | Plays |
|---|---|
| **Fade In**, **Fade Up**, **Slide in from Left**, **Scale In**, **Blur In**, **Reveal (Wipe Up)**, **Children one by one**, **Words Rise**, **Words Slide Up (Masked)** | As the block scrolls into view |
| **Parallax**, **Zoom While Scrolling**, **Fade Through**, **Highlight Words**, **Rotate While Scrolling**, **Slide Sideways** | Along with the scroll |
| **Lift**, **Grow**, **Zoom Image Inside**, **Press** | On hover, or while pressed |
| **Float**, **Spin**, **Pulse** | In a loop |
| **Intro: Fade Up**, **Intro: Words**, **Intro: Children** | As the page loads |
| **Open (Fade and Scale)**, **Slide in Panel** | When an interaction plays it |

The word presets only show for blocks with text.

## Choose when it plays

The **Trigger** decides when an animation runs.

| Trigger | Plays |
|---|---|
| **Appear** | Once, when the block scrolls into view. **Starts** says how far in: **A little into view** by default. Turn on **Reverse When Scrolled Back** to replay it |
| **Scroll** | Along with the scroll, between a **From** and a **To** point, like from when the block enters the screen to when it leaves |
| **Hover** | When pointed at or focused with the keyboard, and reverses after |
| **Press** | While pressed |
| **Page Load** | As the page first appears |
| **Loop** | Over and over. It stops within 5 seconds unless **Repeat** is **Forever** |
| **On Event** | When a [Play Animation](/design/interactions#actions) action plays it: for menus, modals and tabs |

**Appear** and **Scroll** can **Watch** another block: the animation plays when that one comes into view.

To keep something in place while a scroll animation plays, make it sticky in **Design** (**Position**), inside a taller parent, and let the animation watch that parent.

## Change how it moves

An animation is made of one or more steps. Each step moves a **Target** from one look to another:

| Target | Moves |
|---|---|
| **This Element** | The block itself |
| **Each Child in Turn** | The blocks inside it, one after another |
| **Each Word** | The text, word by word. It stays real text for readers and search engines. **Rise from Behind a Line** makes each word slide up from behind an edge |
| **Another Element** | Any other block on the page |

**From** is how the step starts, **To** is how it ends. Leave a side empty to use the block's own design: from *opacity 0, move Y lg* fades the block in and slides it up into place.

You can animate opacity, movement (also in depth), scale, rotation (also in 3D), skew, blur, brightness, grayscale, clip reveals, colors, corner radius, shadow and letter spacing, plus the origin and perspective. Like styles, every value is a name from your [design system](/design/design-system): distances are spacing steps (*lg*, *-2xl*) or *full*, opacity and scale are steps like *0*, *90* and *100*, colors are your scheme's roles and palettes, and clip reveals are shapes like *hidden-down*, *hidden-left* or *circle-hidden* that open to *visible*.

Under **Timing**, pick a **Duration** and a **Delay** from the theme's durations, from *fastest* to *glacial*, and, for children or words, the time between items. The theme's **Speed** makes them all snappier or calmer at once. **Easing** sets the feel: *out* for things arriving, *in* for things leaving, *in-out*, *expo* and *emphasized* for confident reveals, *swift* for interface, and *overshoot*, *anticipate*, *spring*, *bounce* or *linear*.

Press **Add Step** to animate more in the same animation. Each step starts when the one before ends, unless you give it its own start, in seconds into the timeline.

## Play it on some screens only

**Plays on Desktop**, **Plays on Tablet** and **Plays on Phone** choose where an animation runs. For different motion on phones, add two animations and turn each on where it belongs.

## Play it from an interaction

Give the animation the **On Event** trigger. Then, in an event under **Events**, add the **Play Animation** action, choose the block and the animation, and whether to play, reverse, toggle or restart it. A menu panel can slide in when its button is clicked. See [Interactions](/design/interactions).

## Motion that loops

A loop that runs forever needs a **Motion Toggle** block on the page, so visitors can pause it. The build warns when a page has none.

Longer stories that repeat, like a product demo built from several steps, are possible too: see [A timeline that loops](#a-timeline-that-loops).

## Fast and accessible

- **Page Load**, **Scroll** and **Loop** are plain CSS, with no script, so they never hold back the page. **Appear**, **Hover**, **Press** and **On Event** use a small script that only loads on pages that need it. If it never runs, everything shows as designed.
- A **Page Load** animation decides when the page looks done, so it stays short: its delay stops at 0.2 seconds and its last item starts by 0.3 seconds, however long a stagger you set.
- **Appear** skips anything already on screen when the page opens.
- Visitors who ask for reduced motion get the finished design: appear, load, scroll and loop animations don't run, and hover, press and event animations jump to their end.
- Content is never hidden waiting for a script, and printing shows everything. A browser without scroll-driven animations shows the design in its final state.

::: callout {"props":{"tone":"tip","text":"A block with <code>overflow: hidden</code> becomes the scroller for a scroll animation inside it. Use <code>overflow: clip</code> instead."}}
:::

## For developers

### How it is stored

A block's `motion` is a list of animations:

```json
[
  { "id": "m1", "name": "Words rise", "trigger": { "type": "appear", "start": "top 85%", "once": true },
    "steps": [{ "target": "words", "from": { "opacity": "0", "y": "md" }, "duration": "slow", "ease": "out", "stagger": "fastest" }] },
  { "id": "m2", "trigger": { "type": "scroll", "start": "top bottom", "end": "bottom top" },
    "steps": [{ "target": "self", "from": { "y": "-3xl" }, "to": { "y": "3xl" }, "ease": "linear" }] },
  { "id": "open", "trigger": { "type": "event" },
    "steps": [
      { "target": "self", "from": { "x": "full" }, "duration": "base", "ease": "swift" },
      { "target": "children", "from": { "opacity": "0", "x": "lg" }, "duration": "base", "stagger": "fastest" }
    ] }
]
```

- `trigger.type`: `appear`, `scroll`, `hover`, `press`, `load`, `loop`, `event`. `start` and `end` read `<element edge> <viewport position>`, with `top`, `center` or `bottom` for the edge and those or a percentage for the position (`top 80%`, `center center`). `node` (`#<block id>`) watches another element.
- `on`: `desktop`, `tablet`, `mobile`; absent means every screen.
- `steps[].target`: `self`, `children`, `words` or `#<block id>`; `steps[].mask` clips each word.
- `steps[].from` and `to` take the names their style property takes: `opacity` (`0`…`100`), `x`, `y` (space steps, negative steps, fractions, `full`), `z`, `scale`, `scaleX`, `scaleY` (`90`, `100`, `105`…), `rotate`, `rotateX`, `rotateY` (`0`, `1`, `2`, `3`, `6`, `12`, `45`, `90`, `180`, negative too), `skewX`, `skewY`, `perspective`, `blur`, `brightness`, `grayscale`, `clipPath` (`visible`, `hidden-up`, `hidden-down`, `hidden-left`, `hidden-right`, `hidden-center`, `circle-hidden`, `circle-visible`), `backgroundColor`, `color`, `borderColor` (color names), `borderRadius`, `boxShadow`, `letterSpacing` and `transformOrigin`.
- `steps[].duration`, `delay` and `stagger` are durations: `instant`, `fastest`, `faster`, `fast`, `base`, `slow`, `slower`, `slowest`, `glacial`. `steps[].ease` is an easing: `linear`, `in`, `out`, `in-out`, `expo`, `emphasized`, `swift`, `overshoot`, `anticipate`, `spring`, `bounce`. The theme sets what each one is ([motion](https://design.lettern.org/spec/motion/)).
- `steps[].at` is where a step starts on its timeline, in seconds: with `hold`, the only times that aren't names. Without it a step starts when the previous one ends.
- `repeat` (`-1` forever) and `yoyo` repeat each step; with `hold` (seconds of rest) on an appear animation they repeat the whole timeline.

Anything outside the vocabulary is dropped when the block is saved. Page Load, Scroll and Loop compile to CSS (scroll-driven animations for Scroll); the other triggers use the Web Animations API.

A play action names the block and the animation id: `{ "do": "play", "node": "b9x2k4", "motion": "open", "mode": "toggle" }`.

### A timeline that loops

To tell a short story that repeats, add every moment as a step of one **Appear** animation with `repeat: -1` and a `hold` (the rest at the end, in seconds). Give each step a target and an `at` time, and the steps play as one timeline: it starts when the element comes into view, pauses when it leaves, and between steps each target stays where its last step left it. Give a target several steps to bring it in and take it out again, and fade the whole stage out at the end, so the restart doesn't show.

The element's own styles are the finished state, so they should show the story's end: that is what visitors see with reduced motion or with scripts off. The page needs a **Motion Toggle** block, like anything that runs forever. Words and children can't be part of such a timeline: target elements.

```json
{ "id": "demo", "trigger": { "type": "appear" }, "repeat": -1, "hold": 3, "steps": [
  { "target": "#prompt", "from": { "clipPath": "hidden-left" }, "to": { "clipPath": "visible" }, "at": 0.5, "duration": "slowest", "ease": "linear" },
  { "target": "#answer", "from": { "opacity": "0" }, "at": 2.5, "duration": "base" }
] }
```
