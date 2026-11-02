---
id: 01m5wn8raqyc48b4yctx4mr6n6
title: SEO and GEO
position: 2
description: Help search engines and AI assistants find your pages, understand them and quote them. Most of it happens by itself.
---
The SEO plugin gets your site found in two places: search engines like Google (that's SEO), and AI assistants like ChatGPT, Claude and Perplexity that answer questions by quoting websites (that's GEO, generative engine optimization). Most of it works without you doing anything. You check each page as you write, and set a few defaults once.

![The SEO tab of the home page: search preview, title and description, and the checks.](/media/screens/operations-seo.webp)

## What every page gets by itself

- A page title and a description for search results, and a canonical address, so search engines know which URL is the real one.
- A preview card with an image when someone shares the page on social media or in a chat.
- Structured data that tells search engines who you are, what the page is and where it sits on the site.
- A sitemap that lists every page, and a plain-text version of each page that AI tools can read easily.
- On a site with several languages, links between the translations of each page.

## Check a page

Open a page and choose the **SEO** tab on the right. You see how the page will look in search results, and a score from a list of checks: title length, meta description, one main heading, clear structure, alt text on every image, enough substance, an opening paragraph that answers first, question-style headings, internal links, whether the page can be indexed, and a social image.

You can also change what search engines see:

| Field | What it does |
|---|---|
| **SEO Title** | The title in search results, if it should differ from the page title. |
| **Meta Description** | The text under the title. Without one, the first paragraph is used. |
| **Social Image** | The picture on the preview card. |
| **Canonical URL** | Point to another page when this one is a copy of it. |
| **Page Type** | Tell search engines what kind of page it is: an article, an about page, a contact page… |
| **Hide from Search Engines** | Keep this page out of search results. |

The **SEO Health** card on the dashboard shows how all your published pages score, and which to fix first.

## Set the site-wide defaults

Under **Settings → SEO & AI visibility**, set these once:

- **Title Format**: how page titles are built, like `{title} · {site}`.
- **Default Social Image**: used on pages without their own.
- **You Are**, **Name**, **Logo** and **Profiles**: who is behind the site (an organization, a local business or a person), for search engines.
- **Summary for AI (llms.txt)**: one or two sentences on who you are and what the site offers.

## Choose which AI crawlers may visit

AI companies send two kinds of crawlers. **Training** crawlers (GPTBot, ClaudeBot, Google-Extended, Applebot-Extended, CCBot…) collect text to train models. **Search** and **browsing** crawlers (OAI-SearchBot, ChatGPT-User, Claude-SearchBot, Claude-User, PerplexityBot…) fetch your pages to answer someone's question, and link back to you.

Pick the ones to keep out in **Block These AI Crawlers**. Blocking training crawlers while allowing search ones keeps you quotable in answers without feeding models.

## Redirect old addresses

When you change a page's address, Lettern adds a permanent redirect from the old one by itself, so links and search results keep working. To add or change redirects yourself, open **Redirects** and press **New Redirect**.

## Keep a staging site out of search

On a staging or test copy of a site, turn on **Discourage All Indexing (Staging Sites)** under **Settings → SEO & AI visibility**.

## For developers

### Tags on every page

A `<title>` from the title format, a meta description, a canonical URL and `robots`; Open Graph and social card tags with an image (the page's own, or the site default); `hreflang` links between translations; and a JSON-LD graph: your organization, the website, the page, breadcrumbs, articles for dated collections, and FAQ data from accordion blocks.

### Site files

| File | Purpose |
|---|---|
| `/sitemap.xml` | Every live, indexable page, with alternates per language. With more than one language it is an index of `/sitemap-en.xml`, `/sitemap-de.xml` and so on. |
| `/blog/feed.xml` | RSS for each collection of dated entries, per language (`/de/blog/feed.xml`), linked from its pages. Set `feed: false` on the collection to turn it off, or `feed: {path, limit, title}` to change it. |
| `/robots.txt` | Points to the sitemap and blocks the AI crawlers you chose. |
| `/llms.txt` | A summary of the site and links to its pages' Markdown, for AI tools. |
| `/.well-known/security.txt` | Where to report a vulnerability, once you set **Security Contact** to an email address or a page. |
| `/<page>.md` | A clean Markdown version of every page, its **Markdown twin**. Pages announce it with `<link rel="alternate" type="text/markdown">`. Turn it off with **Publish Markdown versions of pages (/page.md)**. |

On a static site these files are written with every build. See [Publishing](/operations/publishing).

### Checks and redirects for agents

The page checks are the `seo/analyze` ability, and the site-wide picture is `seo/health`, so an agent can audit every page and fix what it finds. Redirects are stored in `content/redirects.yaml` and changed with `redirects/list` and `redirects/save`. They can be 301, 302, 307 or 308. On static sites they are written as small redirect pages, so they work without PHP.
