---
id: 01m5wn8r8npxz0heybf16eex0k
title: Design
position: 4
description: Everything visitors see is built in the CMS — pages, templates, header and footer, styles, scripts and animations. No theme files, no build step.
---
In Lettern a site's design is content. Pages, the templates around them, the header and the footer are all block documents you edit in the shared [block editor](/editing/writing). Colors, type and spacing live in a design system you edit in the admin. Scripts and animations are settings on blocks, not files. People design it in the builder; developers and their agents change the same files through abilities, MCP or git.

## Where things live

| What | Where | Edited in |
|---|---|---|
| Design system — tokens, fonts, element styles, buttons, page transitions | `content/design/tokens.json` | **Design system** (tokens), the `design/update` ability |
| Extra CSS and JavaScript | `content/design/custom.css`, `custom.js` | The files, or the `design/code` ability |
| Fonts | `content/design/fonts/*.woff2` | The `design/fonts-import` and `design/fonts-upload` abilities |
| Page templates (header, Page content, footer…) | `content/collections/templates/*.md` | **Templates** — opens in the block workspace |
| Components and sections | `content/collections/components/*.md` | **Components** — opens in the block workspace |
| Pages and other entries | Their collection | The shared block editor |

Templates and components are ordinary [collections](/content/collections), so they have drafts, publishing, history, comments and the `entries/*` abilities like everything else.

## How a page is built

1. The entry picks a [template](/design/templates): its own choice, its collection's, or `default`.
2. Lettern renders the template's blocks. Components inside it — the header, the footer — render in place.
3. The **Page content** block in the template renders the entry's own blocks.
4. Every block's styles become small, shared CSS classes; [scripts](/design/interactions) and [animations](/design/animations) add only the JavaScript the page uses.
5. The page is written to `public/` as HTML — see [Static builds](/design/static-builds).

## In this section

- [Design system](/design/design-system) — tokens, fonts, element styles, buttons, page transitions, custom code
- [Styles](/design/styles) — CSS on any block, per screen size and state
- [Templates](/design/templates) — the frame around every page
- [Components](/design/components) — reusable designs with properties
- [Data and Repeat](/design/data) — show entries, menus and fields
- [Interactions](/design/interactions) — state, events and actions
- [Animations](/design/animations) — appear, scroll, hover and timelines
- [Static builds](/design/static-builds) — how pages are published
- [SEO and GEO](/design/seo-and-geo) — search engines and AI answers
