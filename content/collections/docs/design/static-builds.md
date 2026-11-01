---
id: 01m5wn8raem84e0vbv0gv53twe
title: Static builds
position: 8
group: 'Ship'
description: 'Lettern publishes pages as HTML files, rebuilding only what a change affects — without a build server, a queue worker or cron.'
---
## What happens when you publish

1. Lettern works out which pages the change affects. Every page records what it read while rendering — the entry itself, the collections it listed, global sets, menus, linked pages, the components it shows — so editing a post rebuilds the post, the blog index and the home page that lists it, and publishing the header rebuilds the pages that show the header, not the whole site.
2. Those pages are rendered with their [templates](/design/templates) and written to `public/` (`/about` becomes `public/about/index.html`), together with paginated pages, the 404 page and the site files: `sitemap.xml`, `robots.txt`, `llms.txt`, `search.json` and each page's Markdown twin.
3. The web server serves the files directly. PHP is not involved in a page view.

Changes that touch every page — the [design system](/design/design-system), any template, site settings, a collection's definition — queue a full rebuild. So does updating Lettern or a plugin: built pages name scripts and styles by version, so the first request after an update rebuilds them.

## What a page loads

A built page is HTML and CSS. JavaScript comes only with what the page uses: the scripts runtime for [interactions](/design/interactions), a small player for [animations](/design/animations) that wait for scrolling or hover (the rest are plain CSS), syntax highlighting for code blocks, and instant search for the Search block — each a separate file, loaded on demand. A page with none of these has no JavaScript at all (plus `custom.js`, if the site has one).

## No worker needed

The build runs in small chunks after the response that triggered it has been sent, and continues while the admin is open (the dashboard shows progress). On a busy site you can also build from the command line:

```bash
php cms build
```

The `site/build` and `site/build-status` abilities let agents and scripts start a rebuild and watch it.

## Nothing personal reaches a built page

A build often runs after somebody's request, and what it writes is public. So it always runs as a visitor nobody knows: every auth guard answers "no one" while it renders, even when the person whose request triggered it is signed in. A plugin can check who a page is for with `$context->mode` in hooks like `site.scope`: `build` is a public file, `request` is the person asking, `preview` and `editor` are the admin's.

Pages rendered on request follow the same line: anonymous ones may be cached (`public, s-maxage=60`) and carry no cookie; one rendered for somebody signed in is `no-store, private`.

## Previews

Editors preview drafts at `/__preview/<entry id>` — rendered on request with the working copy and the unpublished changes of templates and components, for signed-in users only. The live editing surface uses this same renderer; Preview runs the page without editing affordances.

## Turning it off

Under **Settings → Site & publishing** you can switch static builds off; every page then renders on request. You can also stop automatic rebuilds and publish the whole site by hand.

## Checking links

`cms links:check` reads the built `public/` and fails when an internal link, image or `#anchor` leads nowhere, listing each one with its page. External links are left alone. Run it after `cms build`; CI does.

## Deploying elsewhere

Because the output is plain files, you can sync `public/` to any static host or CDN after a build, and run the admin on a private server.

Pages behind the [gate](/content/gated-content) are the exception: they are never written as files, because they read differently per person.
