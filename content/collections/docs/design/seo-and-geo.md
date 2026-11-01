---
id: 01m5wn8raqyc48b4yctx4mr6n6
title: SEO and GEO
position: 9
group: 'Ship'
description: Meta tags, structured data, sitemaps, redirects and the extra files AI assistants use to find, understand and quote your site.
---
The SEO plugin handles search engines (SEO) and generative engines — ChatGPT, Claude, Perplexity, Google's AI answers (GEO).

## Every page gets

- A `<title>` from the page title and your title format, a meta description, a canonical URL.
- Open Graph and social card tags with an image (the page's own, or the site default).
- A JSON-LD graph: your organization, the website, the page, breadcrumbs, and articles for dated collections — plus FAQ data from accordion blocks.
- `hreflang` links between translations on multilingual sites.

Editors set a page's title, description, social image, canonical URL, schema type or `noindex` in the **SEO** panel of the entry. Site-wide defaults live in **Settings → SEO**.

## Site files

| File | Purpose |
|---|---|
| `/sitemap.xml` | Every live, indexable page, with alternates per language. With more than one language it is an index of `/sitemap-en.xml`, `/sitemap-de.xml` and so on. |
| `/blog/feed.xml` | RSS for each collection of dated entries, per language (`/de/blog/feed.xml`), linked from its pages. Set `feed: false` on the collection to turn it off, or `feed: {path, limit, title}` to change it. |
| `/robots.txt` | Points to the sitemap; blocks the AI crawlers you choose. |
| `/llms.txt` | A summary of the site and links to its pages' Markdown, for AI tools. |
| `/.well-known/security.txt` | Where to report a vulnerability, once you set **Security Contact** to an email address or a page. |
| `/<page>.md` | A clean Markdown version of every page (its **Markdown twin**). Pages announce it with `<link rel="alternate" type="text/markdown">`. |

## AI crawlers

Choose per crawler whether it may use your content: training crawlers (GPTBot, ClaudeBot, Google-Extended, Applebot-Extended, CCBot…) and the search and browsing agents that fetch pages to answer questions (OAI-SearchBot, ChatGPT-User, Claude-SearchBot, Claude-User, PerplexityBot…). Blocking training while allowing search agents keeps you quotable in answers without feeding models.

## Checks

The SEO panel scores each page as you write: title length, meta description, one main heading, clear structure, alt text on every image, enough substance, an answer-first opening paragraph, question-style headings, internal links, indexability and a social image. The same checks are the `seo/analyze` ability, so an agent can audit every page and fix what it finds.

## Redirects

When a page's URL changes, Lettern adds a permanent redirect from the old one automatically. Manage redirects in **Redirects** (stored in `content/redirects.yaml`); on static sites they are written as small redirect pages so they work without PHP.
