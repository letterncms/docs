---
id: 01m5wmrf516991y0hwvvf2z7wn
title: Languages
position: 7
group: 'Manage'
description: Publish every page in several languages, with proper URLs, hreflang, a language switcher and optional AI translation.
---
## Adding languages

Open **Languages** and add the languages you need. The default language lives at the root (`/about`); others get a prefix (`/de/about`). Prefer `/en/about` too? Turn on **Prefix the default language**. Changing languages or the default updates every URL, and the old addresses redirect.

## Translating a page

Open a page and use the language menu in the toolbar:

- **Translate into Deutsch** — with the assistant set up, Claude translates the text and the new version opens as a draft for review. Only words are sent for translation; block structure, links, images and design tokens are copied unchanged.
- **Add version / Copy for manual translation** — copies the page as a draft for someone to translate.

Each translation is linked to the original, so you can switch between versions, and pages are placed under the translated parent in a tree. The entries list has a language switch at the top.

A translation starts with its own place in search: it does not inherit a canonical URL or a noindex from the original. Give it its own slug and SEO title, written for that language: `/de/preise`, `/fr/tarifs`.

## URLs per language

Tree pages take their URL from their parents, so `/de/vergleich/wordpress` is a page `wordpress` under a German page `vergleich`. A collection with a fixed pattern can have another one per language with `routes` in its YAML:

```yaml
route: /whats-new/{slug}
routes:
  de: /neuigkeiten/{slug}
  fr: /nouveautes/{slug}
```

A language without a pattern of its own uses `route`, under its prefix. A collection's feed follows the same pattern.

## On the site

- `<html lang>` and `dir` follow the page (right-to-left languages included).
- Each page lists its live translations as `hreflang` links, with an `x-default`, also in the sitemap.
- Links follow the visitor. A link to `/pricing`, written in a block, a template, a menu or rich text, leads to `/de/preise` on a German page once that version is live, and stays on the original until then. A link with an `hreflang` attribute means what it says and is left alone: use it on a language switcher.
- Menus show the visitor's language where a translation is live, and each menu item can have its own label per language ([Navigation](/content/navigation)).
- Forms have their wording per language, and answer in it ([Forms](/editing/forms)).
- A missing page under `/de/` shows the 404 template in German.
- Text from the code (the skip link, a form's error messages) and dates (`entry.date|date`) follow the page's language.
- `/sitemap.xml` is an index of `/sitemap-en.xml`, `/sitemap-de.xml` and so on once more than one language has pages.
- A **Repeat** over **Languages** makes a language switcher: bind a Link's label to `item.name` (or `item.locale`), its URL to `item.url`, its `hreflang` and `lang` attributes to `item.locale`, and the `current` state to `item.current`. In PHP, `cms_translations()` returns the same list.

Languages without a live version of the page link to their home page instead, and are left out if that does not exist either.

## Templates and components

Templates and components exist once, so a design change reaches every language. The words in them come from a global set, which holds a value per language: switch language at the top of the set, and bind a block to it with `globals.ui.sign_in`. A value can be part of a sentence: `{globals.ui.sold_by} {globals.company.display_name}`.

## A page that stays in one language

To show content in the original language on purpose, publish a version with a short note in the reader's language and tick **noindex**. It stays out of `hreflang` and the sitemap, so search engines keep showing the original. This site's changelog works this way.
