---
id: 01m5wmrf516991y0hwvvf2z7wn
title: Languages
position: 6
description: Publish your site in several languages, each page with its own address, translated by you or by AI.
---
Lettern can publish every page in several languages. Each translation is its own version of the page, with its own address, and visitors stay in their language as they click around.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"One page, About at /about, has a German version at /de/ueber-uns and a French version at /fr/a-propos.\"><div class=\"cluster\" data-gap=\"sm\"><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">About</span><span class=\"badge\">/about</span></span></div><b class=\"text-label\">The original</b><figcaption>In your default language</figcaption></figure><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Über uns</span><span class=\"badge\">/de/ueber-uns</span></span><hr class=\"divider\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">À propos</span><span class=\"badge\">/fr/a-propos</span></span></div><b class=\"text-label\">Translations</b><figcaption>Linked to the original</figcaption></figure></div></div></figure>"}}
:::

## Add a language

Open **Settings → Languages**, press **Add Language** at the top and pick one from the list. Type to search it; any language code works too, like `es-AR`.

Your default language lives at the root of your site (`/about`), and every other language gets its own prefix (`/de/about`). Prefer `/en/about` too? Click the default language and choose **Add URL Prefix**.

To make another language the default, click its row and choose **Make Default**. Its pages move to the root, and the old addresses redirect automatically. **Remove**, in the same place, works once the language has no entries left. The same actions are in each row's menu.

## Translate a page

Open a page and press the language button in the toolbar. It shows the language you're in, like **EN**.

- **Translate into Deutsch** lets the [assistant](/agents/assistant) translate the page for you. Only the words are sent; the layout, links, images and design stay as they are.
- **Copy for Manual Translation (DE)** copies the page for you or a translator to rewrite.

Either way, the new version opens as a draft. Read it through, then publish.

::: callout {"props":{"tone":"tip","text":"AI translation needs the assistant set up with an Anthropic API key. Without it, the menu offers <strong>Add Deutsch Version</strong>, which copies the page for manual translation."}}
:::

Each translation stays linked to the original, so the same menu takes you between them. A page that sits under another page needs that parent translated first, so it has a place to go. In the list of entries, switch language at the top.

## Give each translation its own address

A translation starts with its own place in search: it doesn't take over the original's canonical address or its **Hide from Search Engines** setting. Give it a slug and an SEO title written for that language, like `/de/preise` or `/fr/tarifs`.

## What visitors get

Lettern takes care of the details that make a multilingual site work:

- **Links follow the visitor.** A link to `/pricing` leads to `/de/preise` on a German page once that version is live, and to the original until then. This works in blocks, templates, menus and rich text.
- **Menus** show the visitor's language where a translation is live, and each item can have its own label per language. See [Navigation](/content/navigation).
- **Forms** have their wording per language, and answer in it. See [Forms](/editing/forms).
- **A missing page** under `/de/` shows your 404 page in German.
- **Search engines** learn which pages are translations of each other, and each language gets its own sitemap.
- **Right-to-left** languages are laid out right to left.
- **Dates** and the small bits of text Lettern adds itself, like form errors, follow the page's language.

## Translate templates and components

Templates and components exist once, so a design change reaches every language at once. Put the words in them in a [global set](/content/globals), which holds a value per language, and bind the blocks to it. Switch language at the top of the set to translate them.

## Add a language switcher

Add a **Repeat** block over **Languages**, with a **Link** inside. It lists the current page in every language. Where a page has no live translation, the switcher links to that language's home page instead, and leaves the language out if that doesn't exist either.

## Keep a page in one language

Sometimes a page should stay in its original language, like a changelog. Publish a version with a short note in the reader's language, and turn on **Hide from Search Engines** in its **SEO** tab. It stays out of the list of translations search engines see and out of the sitemap, so they keep showing the original. This site's changelog works this way.

## For developers

### Addresses per language

Tree pages take their URL from their parents, so `/de/vergleich/wordpress` is a page `wordpress` under a German page `vergleich`. A collection with a fixed pattern can have another one per language, with `routes` in its YAML:

```yaml
route: /whats-new/{slug}
routes:
  de: /neuigkeiten/{slug}
  fr: /nouveautes/{slug}
```

A language without a pattern of its own uses `route`, under its prefix. A collection's feed follows the same pattern.

### In the HTML

- `<html lang>` and `dir` follow the page.
- Each page lists its live translations as `hreflang` links, with an `x-default`, also in the sitemap. A noindex version is left out of both.
- `/sitemap.xml` becomes an index of `/sitemap-en.xml`, `/sitemap-de.xml` and so on once more than one language has pages.
- A link with an `hreflang` attribute means what it says, and is left alone instead of following the visitor. Use it on a language switcher.

### The language switcher

In a **Repeat** over **Languages**, bind a Link's label to `item.name` (or `item.locale`), its URL to `item.url`, its `hreflang` and `lang` attributes to `item.locale`, and the `current` state to `item.current`. In PHP, `cms_translations()` returns the same list.

### Text in templates

Bind a block to a global value per language with `globals.ui.sign_in`. A value can be part of a sentence: `{globals.ui.sold_by} {globals.company.display_name}`. Dates bound with `entry.date|date` follow the page's language.
