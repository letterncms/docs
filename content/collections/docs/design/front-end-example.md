---
id: 01m75f2py21fbzdq42np74hh6d
title: A pinned scroll scene and a 3D canvas
position: 10
description: 'A worked example: a section that holds while the scroll plays it, a number that counts along, and a Three.js canvas that keeps drawing from page to page.'
---
This example adds three things to a new site, from start to finish:

- On the home page, the section "What you can do next" holds at the top of the screen while the scroll plays it: its heading rises, then its three columns.
- A number in that section counts up with the scroll.
- Behind every page, a Three.js canvas draws a slowly turning shape. It is the same canvas on every page: following a link doesn't restart it.

The first needs no code at all, the second a few lines, and only the third a library. It uses [animations](/design/animations), [scripts and styles](/design/code), [block behaviors](/design/behaviors) and [navigation without page loads](/design/page-navigation). Every command and file here was run on a site made with `cms install`.

## 1. Pin the section and play it with the scroll

Open the home page and select the section "What you can do next". Under **Interact**, add a **Custom Animation**:

1. Set its **Trigger** to **Scroll**, its **Pin Distance** to `150vh` and its **Smoothing** to `0.6`.
2. In the first step, set the **Target** to **Another Element** and pick the heading. Under **From**, set opacity `0` and move Y `60`.
3. Press **Add Step**, target the columns the same way, and give it the same **From**.

The section now stops at the top of the screen for one and a half screens of scrolling. First the heading comes in, then the columns, each trailing the scroll a little, and then the page moves on.

Stored on the block, that is:

```json
{
  "type": "section",
  "motion": [{
    "id": "story",
    "trigger": { "type": "scroll", "pin": "150vh", "scrub": 0.6 },
    "steps": [
      { "target": "#mb4ed9afa0f", "from": { "opacity": 0, "y": 60 }, "duration": 1, "ease": "power3.out" },
      { "target": "#m78d291fb45", "from": { "opacity": 0, "y": 60 }, "duration": 1, "ease": "power3.out" }
    ]
  }]
}
```

The two ids are the heading's and the columns' on a new site. A step without a start time begins when the one before it ends.

## 2. Count with the scroll

An animation that trails the scroll tells its element how far along it is: it sets `--cms-progress`, from 0 to 1, and dispatches `cms:progress`. A behavior turns that into a number.

`content/design/scripts/count.js`:

```javascript
// A number that counts with the scroll, from the progress its pinned section reports.
export function mount(el, props, { signal }) {
  // Props are typed by whoever edits the page: take a number, and only within a range.
  const to = Math.min(Math.max(Number(props.to) || 100, 1), 100000)

  // The section says how far along it is; the event bubbles, so the document hears it.
  document.addEventListener('cms:progress', (event) => {
    if (!event.target.contains(el) || event.detail.progress === null) return
    el.textContent = String(Math.round(event.detail.progress * to))
  }, { signal })
}
```

Add a **Paragraph** at the end of the section with the text `100`. Under **Interact → Behaviors**, choose the **Script** `count`, press **Add Option** and set `to` to `100`.

The text you typed is what visitors see when the script never runs, and what those who ask for less motion get: then there is no progress to follow, and the number stands at its end.

## 3. Add Three.js and write the scene

The canvas is the one part that needs a library:

```bash
php cms vendor add three@0.160.0
```

```
   INFO  three 0.160.0: import … from "three".
```

`content/design/scripts/scene.js`:

```javascript
// A WebGL canvas behind the page. Its block is persisted, so one scene lives across pages.
import * as THREE from 'three'

export function mount(el, props, { token, reducedMotion, signal }) {
  const speed = Math.min(Math.max(Number(props.speed) || 0.2, 0), 2)

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true })
  renderer.setPixelRatio(Math.min(devicePixelRatio, 2))
  el.append(renderer.domElement)

  const scene = new THREE.Scene()
  const camera = new THREE.PerspectiveCamera(40, 1, 0.1, 100)
  camera.position.z = 6
  const mesh = new THREE.Mesh(
    new THREE.IcosahedronGeometry(2, 1),
    new THREE.MeshBasicMaterial({ color: new THREE.Color(token('color.primary') || '#1d4ed8'), wireframe: true, transparent: true, opacity: 0.35 }),
  )
  scene.add(mesh)

  const resize = () => {
    renderer.setSize(el.clientWidth, el.clientHeight, false)
    camera.aspect = el.clientWidth / Math.max(1, el.clientHeight)
    camera.updateProjectionMatrix()
  }
  const observer = new ResizeObserver(resize)
  observer.observe(el)
  resize()

  // Each new page turns the shape a little further. `signal` removes the listener when the block leaves.
  let turn = 0
  document.addEventListener('cms:after-enter', () => (turn += Math.PI / 3), { signal })

  let frame = 0
  const draw = (time) => {
    mesh.rotation.y += (turn + time * 0.001 * speed - mesh.rotation.y) * 0.05
    mesh.rotation.x = time * 0.0005 * speed
    renderer.render(scene, camera)
    // One still frame while the visitor asks for less motion, or has paused it.
    if (!reducedMotion) frame = requestAnimationFrame(draw)
  }
  frame = requestAnimationFrame(draw)

  return () => {
    cancelAnimationFrame(frame)
    observer.disconnect()
    renderer.dispose()
    renderer.domElement.remove()
  }
}
```

The shape takes its color from the design: `token('color.primary')`. `reducedMotion` is true for visitors who ask for less motion and for those who paused it with a **Motion Toggle** block; the behavior is mounted again when that changes, so the loop starts and stops with it.

And `content/design/styles/scene.css`, which puts the canvas behind the page:

```css
.stage { position: fixed; inset: 0; z-index: -1; pointer-events: none; }
.stage canvas { display: block; width: 100%; height: 100%; }
```

Load the stylesheet on every page:

```bash
php cms run design-code/set-load --input='{"styles":["scene"]}'
```

The two scripts need no entry there: the blocks that name them load them.

## 4. Turn on navigation without page loads

Set **Design → Motion → Page Transition → Page Loads** to **Instant**, or:

```bash
php cms run design/update --input='{"transition":{"navigation":"client"}}'
```

## 5. Put the stage in the templates

The canvas needs an element on every page. Open each template (**Default**, **Page** and **Article** on a new site) and add a **Box** above the header:

1. Under **Content → Advanced**, set **Classes** to `stage` and **Persist As** to `stage`.
2. Under **Interact → Behaviors**, choose the **Script** `scene`, press **Add Option** and set `speed` to `0.2`.

In the editor the box says which behavior draws it; the preview shows the canvas. In a template's file, `content/collections/templates/page.md`, it is one block:

```
::: box {"id":"t-stage","label":"Stage","class":"stage","persist":"stage","behavior":{"module":"scene","props":{"speed":0.2}},"attrs":{"aria-hidden":"true"}}
:::
```

`aria-hidden` keeps the decoration from screen readers.

## 6. Publish, build and look

Publish the home page and the templates, then:

```bash
php cms build
```

The home page now carries the pinned section, the counter and, through its template, the kept element:

```html
<section class="cms-section" id="next" data-cms-scroll="[{&quot;id&quot;:&quot;story&quot;, … &quot;pin&quot;:1,&quot;scrub&quot;:0.6,&quot;p&quot;:1}]" …>
<p class="cms-paragraph count" data-cms-behavior="/_cms/site/scripts/count-fac170b1e9.js" data-cms-props="{&quot;to&quot;:100}">
<div class="cms-box stage" aria-hidden="true" data-cms-persist="stage" data-cms-behavior="/_cms/site/scripts/scene-….js" data-cms-props="{&quot;speed&quot;:0.2}">
```

In a browser:

- Scroll the home page. The section stops at the top of the screen, its heading and then its columns come in with the scroll, the number counts along, and the page moves on when they are done.
- Click the site's name in the header. You are on that page already, so it scrolls to the top and nothing loads.
- Follow **About** in the header. The page changes without loading, and the shape behind it turns a step and never stops drawing.
- Press **Back**. The home page is there again, and the canvas is still the same one.
- Open the network panel: everything comes from your own site, and Three.js is the only library.

## What to take from it

- Reach for an animation first. Pinning, playing with the scroll and telling scripts the progress are settings, not code.
- A script's work belongs in `mount`, and its undoing in what `mount` returns or in `signal`. Then it survives every way a block can arrive and leave.
- An element that should outlive its page gets a **Persist As** name and sits in the templates.
- Neither script trusts its props, and both stand still for visitors who ask for less motion or pause it.
- When a library is the right tool, such as GSAP for a timeline these settings can't say, add it with [`cms vendor`](/design/code#add-a-library) and drive it from a behavior the same way.
