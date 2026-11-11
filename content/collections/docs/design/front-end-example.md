---
id: 01m75f2py21fbzdq42np74hh6d
title: A scroll timeline and a 3D scene
position: 10
description: 'A worked example: a GSAP timeline pinned to the scroll, and a Three.js canvas that keeps drawing from page to page.'
---
This example adds two things to a new site, from start to finish:

- On the home page, the section "What you can do next" holds at the top of the screen while the scroll plays a GSAP timeline: its heading rises, then its three columns, one after another.
- Behind every page, a Three.js canvas draws a slowly turning shape. It is the same canvas on every page: following a link doesn't restart it.

It uses [scripts and styles](/design/code), [block behaviors](/design/behaviors) and [navigation without page loads](/design/page-navigation). Every command and file here was run on a site made with `cms install`.

## 1. Add the libraries

```bash
php cms vendor add gsap@3.12.5
php cms vendor add gsap@3.12.5 --file=ScrollTrigger.js --as=gsap/ScrollTrigger
php cms vendor add three@0.160.0
```

The files are now in `content/design/vendor/`, pinned in its `lock.json`.

## 2. Write the timeline

`content/design/scripts/timeline.js`:

```javascript
// A GSAP timeline that the scroll plays while its block is pinned.
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

export function mount(el, props, { reducedMotion }) {
  // Without motion the block is simply the block.
  if (reducedMotion) return

  // Props are typed by whoever edits the page: take a number, and only within a range.
  const screens = Math.min(Math.max(Number(props.screens) || 1.5, 0.5), 4)

  const context = gsap.context(() => {
    gsap.timeline({ scrollTrigger: { trigger: el, start: 'top top', end: `+=${screens * 100}%`, scrub: 0.6, pin: true } })
      .from('h2', { yPercent: 80, opacity: 0, ease: 'power3.out' })
      .from('.cms-column', { y: 90, opacity: 0, stagger: 0.2, ease: 'power3.out' }, '<0.2')
  }, el)

  // Undo everything GSAP did to the block, its pin included, when the block leaves the page.
  return () => context.revert()
}
```

`gsap.context()` scopes the selectors to the block and collects what GSAP changes, so one `revert()` puts the block back. That matters once pages swap without loading: the function `mount` returns is what runs when the home page is left.

## 3. Write the scene

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
    // One still frame for people who ask for less motion.
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

The shape takes its color from the design: `token('color.primary')`.

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

Set **Design System → Motion → Page Transition → Page Loads** to **Instant**, or:

```bash
php cms run design/update --input='{"transition":{"type":"fade","duration":0.25,"navigation":"client"}}'
```

## 5. Put the stage in the templates

The canvas needs an element on every page. Open each template (**Default**, **Page** and **Article** on a new site) and add a **Box** above the header:

1. Under **Content → Advanced**, set **Classes** to `stage` and **Persist As** to `stage`.
2. Under **Interact → Behaviors**, choose the **Script** `scene`, press **Add Option** and set `speed` to `0.2`.

In a template's file, `content/collections/templates/page.md`, that is one block:

```
::: box {"id":"t-stage","label":"Stage","class":"stage","persist":"stage","behavior":{"module":"scene","props":{"speed":0.2}},"attrs":{"aria-hidden":"true"}}
:::
```

`aria-hidden` keeps the decoration from screen readers.

## 6. Put the timeline on the section

Open the home page, select the section "What you can do next", and under **Interact → Behaviors** choose the **Script** `timeline`, press **Add Option** and set `screens` to `1.5`. Publish the page.

Stored on the block, that is:

```json
{ "type": "section", "behavior": { "module": "timeline", "props": { "screens": 1.5 } } }
```

## 7. Build and look

```bash
php cms build
```

The home page now carries the import map, the three behaviors (the starter's spotlight is the third) and the kept element:

```html
<script type="importmap">{"imports":{"gsap":"/_cms/site/vendor/gsap@3.12.5/index.js","gsap/ScrollTrigger":"/_cms/site/vendor/gsap@3.12.5/ScrollTrigger.js","three":"/_cms/site/vendor/three@0.160.0/index.js", …},"integrity":{…}}</script>
…
<div class="cms-box stage" aria-hidden="true" data-cms-persist="stage" data-cms-behavior="/_cms/site/scripts/scene-0ffb5188b5.js" data-cms-props="{&quot;speed&quot;:0.2}">
```

In a browser:

- Scroll the home page. The section stops at the top of the screen, its heading and columns come in with the scroll, and the page moves on when they are done.
- Follow **About** in the header. The page changes without loading, the shape behind it turns a step and never stops drawing, and the timeline's pin is gone with the home page.
- Press **Back**. The home page and its timeline are there again, and the canvas is still the same one.
- Open the network panel: everything, the libraries included, comes from your own site.

## What to take from it

- A library's work belongs in `mount`, and its undoing in what `mount` returns. Then it survives every way a block can arrive and leave.
- A script that listens on `document` or `window` passes `signal`, so the listener goes when the block does.
- An element that should outlive its page gets a **Persist As** name and sits in the templates.
- Both scripts stand still for visitors who ask for less motion, and neither trusts its props.
