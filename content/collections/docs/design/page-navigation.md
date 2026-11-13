---
id: 01m75f2px8carsgz6n4d7rtcc4
title: Navigation without page loads
position: 10
description: 'Swap pages in place, so a canvas keeps drawing and audio keeps playing from one page to the next.'
---
Normally a link loads a new page, and everything on the old one ends. With **Instant** page loads, a link to another page of the site fetches that page and swaps it in, inside the [page transition](/design/site-design#page-transitions). The document stays, so chosen elements can stay too: a WebGL canvas keeps drawing, a player keeps playing.

Pages stay the static HTML they were. Without JavaScript, every link loads its page as before.

## Turn it on

Open **Design → Motion → Page Transition** and set **Page Loads** to **Instant**. **Full Page** is the default.

From then on:

- A link to a page of the site swaps the page without a page load.
- A link to the page you are on, like the logo or the current menu item, scrolls to the top and loads nothing, so what is kept across pages isn't restarted.
- A link is fetched ahead when the pointer rests on it, a finger touches it or the keyboard focus lands on it, so the page is there when it is asked for.
- **Back** and **Forward** bring each page back where it was scrolled to.
- Keyboard focus moves to the new page's main content, and its title is announced to screen readers.
- Visitors who ask for less motion get the swap without the transition.

## Keep an element across pages

Give a block a name under **Content → Advanced → Persist As**, like `stage`. When both the page being left and the page arriving have a block with that name, it stays the same element: it is moved to where the new page has it, not replaced. A [behavior](/design/behaviors) on it stays mounted.

Put the block in a template or a component, so every page has it. A page that doesn't have it lets it go, and its behavior is unmounted.

A name is lowercase letters, digits and `-`, starting with a letter.

## Which links load the page anyway

Some links always load their page in full:

- A link with a query string, such as a filter, a sign-out or "add to cart". Fetching ahead must never do anything.
- A link to another site, to a file such as a PDF or a feed, with `download`, with a `target` other than this tab, or with `rel="external"` or `rel="nofollow"`.
- A link inside an element with the attribute `data-cms-reload`.
- Paths under `/admin`, `/api`, `/install`, `/media`, `/_cms` and `/__preview`, and paths a plugin adds.

And a navigation falls back to a normal page load when the swap would not be safe: the next page has a different import map, the site was published anew since this page loaded, the answer is a redirect or an error, or something fails on the way.

Nothing is fetched ahead for visitors who turned on data saving in their browser.

## For developers

### How it is stored

In `content/design/tokens.json`:

```json
"transition": { "type": "fade", "duration": 0.25, "navigation": "client" }
```

`navigation` is `client` or `document` (the default). `design/update` with only part of the transition keeps the rest:

```bash
php cms run design/update --input='{"transition":{"navigation":"client"}}'
```

A block's name is its `persist`:

```json
{ "type": "box", "class": "stage", "persist": "stage", "behavior": { "module": "scene" } }
```

On the page it is `data-cms-persist="stage"`, with a `view-transition-name` of its own, so it holds still while the page around it changes.

### Events

Two events fire on `document`:

| Event | When | `event.detail` |
|---|---|---|
| `cms:before-leave` | Before anything is fetched or changed. A link's navigation can be refused with `event.preventDefault()`; Back and Forward have already happened and can't | `from`, `to`, and `waitUntil(promise)`, which holds the swap until the promise settles, for at most four seconds |
| `cms:after-enter` | After the new page is in place and its blocks have started | `from`, `to` |

```javascript
document.addEventListener('cms:before-leave', (event) => {
  event.detail.waitUntil(curtain.animate({ opacity: [0, 1] }, 200).finished)
})

document.addEventListener('cms:after-enter', () => {
  ScrollTrigger.refresh()
})
```

While a navigation is under way, `<html>` has the attribute `data-cms-navigating`.

### Navigate from a script

```javascript
window.cmsNavigate.go('/about')        // as a link would
window.cmsNavigate.prefetch('/about')  // fetch it ahead
```

`window.cmsNavigate` exists only when the site navigates this way. A fetched page is kept for 30 seconds.

### Scripts run once per visit

With page loads, a module script runs again on every page. Here it runs once, on the first page that loads it, and so does an inline script whose text an earlier page already ran. Do a page's own work in a behavior's `mount`, or on `cms:after-enter`.

Stylesheets follow the page: the next page's are loaded before it shows, and the ones it doesn't use are removed.

### Paths a plugin excludes

A plugin whose pages must always load in full, such as a cart or an account page, adds their paths with the `site.navigate.skip` filter:

```php
$this->cms()->hooks()->addFilter('site.navigate.skip', fn (array $paths) => [...$paths, '/cart']);
```

A path covers itself and everything under it.
