---
id: 01m5wn8raem84e0vbv0gv53twe
title: Publishing
position: 0
description: 'Press Publish and your changes are live: Lettern writes them as fast, plain pages, with no build server and nothing to deploy.'
---
Everything you change in the admin stays private until you publish it. Press **Publish**, and Lettern writes the pages that changed as plain HTML files. Visitors get those files straight from the web server, so the site is fast, even on small hosting.

![The dashboard right after publishing the whole site.](/media/screens/publish.webp)

## Publish a page

1. Open the page, or any entry, and make your changes. They save as you go.
2. Press **Publish** in the top bar, or `⌘⇧P`.

That's it: the page is live a moment later. Once a page is live, new edits wait as unpublished changes. Visitors keep seeing the published version until you press **Publish Changes**.

The **More Actions** menu next to the button has the rest:

| Choose | To |
|---|---|
| **Schedule…** | Pick a date and time for a page that isn't live yet. |
| **Discard Unpublished Changes** | Go back to what's live. |
| **Unpublish** | Take the page off the site. It stays in the admin as a draft. |

People whose role can't publish see **Save Draft** instead, and someone who can publish puts it live. See [Users and roles](/operations/users-and-roles), and [Entries](/content/entries) for drafts, scheduling and history.

## Publish the whole site

The **Site** card on the dashboard tells you whether the live site is up to date: **Up to date**, **Unpublished Changes**, or how far along it is while publishing. **Publish Site** rebuilds every page. You can also press `⌘K` and choose **Publish the Whole Site**.

You rarely need it: publishing a page already updates every page it affects. It's there for when you've turned automatic rebuilds off, or want a fresh copy of everything.

## What happens when you publish

Lettern remembers what each page shows. So when you change something, it rebuilds only the pages that use it, and leaves the rest alone.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"You publish a dish. Lettern rebuilds the dish's page and the menu page that lists it, and writes them as plain HTML files that visitors get directly.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Grilled turbot</b><span class=\"docs-card__field\">Price</span><span class=\"docs-card__field\">Photo</span></div><b>You publish</b><small>One dish</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>/dishes/turbot</span></div><div class=\"docs-card docs-card--row\"><span>/menu</span></div><div class=\"docs-card docs-card--row\"><span>/</span></div></div><b>Lettern rebuilds</b><small>Only the pages that show it</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-mock docs-mock--live\"><i class=\"docs-mock__bar\"></i><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__img\"></i></div><b>Visitors get files</b><small>No PHP, no database</small></div></div></figure>"}}
:::

- **Change a dish**, and its page, the menu that lists it and the home page that features it are rebuilt.
- **Change the header**, and the pages that show the header are rebuilt.
- **Change something every page uses**, like the [design system](/design/design-system), a template, a menu or the site settings, and the whole site is rebuilt.

It runs in the background, a little at a time, so you never wait for it, and there's no server to set up. The dashboard shows the progress.

## Fast by default

A published page is HTML and CSS. It only loads JavaScript for what it actually uses, like an [interaction](/design/interactions) or the Search block. A page with none of those has no JavaScript at all.

## Turn it off

Under **Settings → Site & Publishing**:

| Setting | When it's off |
|---|---|
| **Build a Static Site** | No files are written. Every page is rendered when someone asks for it. |
| **Rebuild Automatically on Publish** | Publishing a page doesn't rebuild the site. Press **Publish Site** when you're ready to put everything live at once. |

Pages behind a [gate](/content/gated-content) are never written as files, because they look different for each person.

## For developers

### How a build works

Every page records what it read while rendering: the entry itself, the collections it listed, globals, menus, linked pages, media and the components it shows. A change queues only the pages that recorded it. Site-wide changes (the design system, a template, site settings, a collection's definition, globals, menus, reordering entries) queue a full rebuild. So does updating Lettern or a plugin: built pages name scripts and styles by version, so the first request after an update rebuilds them.

Pages are rendered with their [templates](/design/templates) and written to `public/`: `/about` becomes `public/about/index.html`. Paginated pages, the 404 page and the site files are written too: `sitemap.xml`, `robots.txt`, `llms.txt`, `search.json` and each page's Markdown twin. The web server serves these files directly.

The build runs in chunks after the response that triggered it has been sent, and continues while the admin is open and polling. No queue worker or cron is needed. On a busy site, build from the command line:

```bash
php cms build
```

The `site/build` and `site/build-status` abilities let agents and scripts start a rebuild and watch it. `site/build` needs the `site.build` permission.

### What a page loads

JavaScript comes only with what a page uses: the scripts runtime for [interactions](/design/interactions), a small player for [animations](/design/animations) that wait for scrolling or hover (the rest are plain CSS), syntax highlighting for code blocks, and instant search for the Search block. Each is a separate file, loaded on demand, plus `custom.js` if the site has one.

### Nothing personal reaches a built page

A build often runs after somebody's request, and what it writes is public. So it always renders as a visitor nobody knows: every auth guard answers "no one", even when the person whose request triggered it is signed in. A plugin can check who a page is for with `$context->mode` in hooks like `site.scope`: `build` is a public file, `request` is the person asking, `preview` and `editor` are the admin's.

Pages rendered on request follow the same line. Anonymous ones may be cached (`public, s-maxage=60`) and carry no cookie. One rendered for somebody signed in is `no-store, private`.

### Previews

Editors preview drafts at `/__preview/<entry id>`: rendered on request with the working copy and the unpublished changes of templates and components, for signed-in users only. The editing canvas uses the same renderer; **Preview** shows the page without the editing controls.

### Check links

`php cms links:check` reads the built `public/` and fails when an internal link, image or `#anchor` leads nowhere, listing each one with its page. External links are left alone. Run it after `php cms build`, for example in CI.

### Host the files elsewhere

The output is plain files, so you can sync `public/` to any static host or CDN after a build, and run the admin on a private server. See [Deployment](/operations/deployment#static-hosting-and-cdns).
