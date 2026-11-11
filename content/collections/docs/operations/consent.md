---
id: 01m75g1y31b5r43nd2jccym0pv
title: Cookie consent
position: 10
description: 'Ask visitors before analytics or marketing scripts run, with a banner in your own design.'
---
The Consent plugin puts a cookie banner on your published site. Visitors accept everything, only what is necessary, or choose between analytics and marketing, and scripts wait for their answer. It is free: install it from **Plugins → Store**, or with `composer require letterncms/consent`.

The banner uses your site's own colors, buttons and switches. It sits over the page, so nothing moves when it appears, and the answer is kept in the visitor's browser, so it works on built pages too.

## What visitors see

- **Accept All** and **Only Necessary** weigh the same, and **Choose** opens a choice between analytics and marketing, saved with **Save Choices**.
- On a phone the banner takes at most half the screen.
- Once they have answered, a **Cookie Settings** button lets them change their mind.
- Visitors whose browser sends Global Privacy Control aren't asked, and nothing is accepted for them.

A site that asks about neither analytics nor marketing shows no banner at all.

## Set it up

Open **Settings → Consent**.

| Setting | Does |
|---|---|
| **Show the Banner** | On by default |
| **Ask About Analytics** | On by default. [Analytics](/operations/analytics) in visitors mode starts counting once a visitor accepts |
| **Ask About Marketing** | Off by default. Turn it on when the site loads marketing scripts |
| **Show Cookie Settings Button** | On by default. Without it, put a link to `#cms-consent` in your footer |
| **Title**, **Text**, **Privacy Policy** | Once per language of the site. Left empty, the banner says its own words in that language, fitted to what it asks about; the empty field shows them |

Asking about another category asks every visitor again.

If Analytics waits for consent while the banner is off, the **Consent** widget on the home screen says so. Otherwise it stays empty.

## For developers

### The consent signal

Scripts on the page learn the answer in three ways.

`window.cmsConsent` holds it:

```javascript
window.cmsConsent
// { necessary: true, analytics: false, marketing: false, decided: false }

window.cmsConsent.open()                                      // show the choices
window.cmsConsent.set({ analytics: true, marketing: false })  // answer for the visitor
```

`decided` is `false` until the visitor has answered.

Every answer, and a stored one on each page load, fires `cms:consent` on `document`:

```javascript
document.addEventListener('cms:consent', (event) => {
  if (event.detail.marketing) loadPixel()   // detail: { necessary, analytics, marketing }
})
```

And a script can simply wait in the page until its category is accepted:

```html
<script type="text/plain" data-cms-consent="marketing">
  // runs once marketing is accepted
</script>
```

Taking a category back reloads the page, so scripts that already ran are gone.

### Opening the choices

A link to `#cms-consent`, or any element with the attribute `data-cms-consent-open`, opens the choices again. Focus returns to where the visitor came from.

### What is stored

The answer is in the first-party cookie `cms_consent`, for six months. Settings are in `config/consent.yaml`: `enabled`, `analytics`, `marketing`, `reopen`, and `title`, `text` and `policy`, each with a value per language (`title: {en: …, pt_br: …}`).

The plugin has no abilities. It adds the banner through the `site.foot` filter, never in the builder or a preview.
