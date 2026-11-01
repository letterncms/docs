---
id: 01m5yz76zg040qnw6kerbpt360
title: Analytics
position: 4
description: See what people read on the published site. Page views by default, with visitors, sources and devices as an option.
---
The **Analytics** plugin (`letterncms/analytics`) counts visits to the published site on your own server. Open **Analytics** in the sidebar for the numbers; the *Analytics* widget on the home screen shows the last 30 days at a glance.

## What it counts

Under **Settings → Analytics**, **What to count** has two settings. Page views only is the default.

| | Page views only (`counts`) | Visitors, sources and devices (`visitors`) |
|---|---|---|
| On the page | One 1×1 image, no script | A few hundred bytes of script |
| Sent | The page's path, written into the page at build | Path, referrer, campaign name, window width |
| Read from the browser | Nothing | Referrer, window width, Do Not Track |
| Kept | Views per day and path | Also a daily hash per visitor, source, device, browser and operating system |
| IP address and browser string | Read in memory to skip bots, then gone | Hashed with a salt that is replaced daily and thrown away |
| Reports | Page views, top pages, languages | All of them |

In both, people who ask not to be tracked (**Do Not Track** or **Global Privacy Control**) and bots are skipped, nothing is counted in previews or the block workspace, and people signed in to the admin aren't counted. That last one uses a `cms_staff` cookie set when someone with admin access signs in. It's HTTP-only and no page or script reads it. A site's members are counted like any visitor.

Visitors mode stores a pseudonymous hash and reads data from the browser. Whether that needs consent depends on your visitors' countries, so check the rules for them. By default it waits for a signal from your consent tool: `window.cmsConsent = { analytics: true }` set before the page's script runs, or a `cms:consent` event on `document` with `detail: { analytics: true }`. Turn off **Wait for consent** if you've decided you don't need it. Web server logs are separate from all of this, and are your host's matter.

Going back to page views only deletes the visitor data and its salt. Views per page stay. Switching to visitors starts collecting from that day.

## What you see

| Number | Means |
|---|---|
| **Page views** | Every page opened. |
| **Visitors** | Different people per day, added up over the period. Visitors mode. |
| **Views per visit** | Page views divided by visitors. Visitors mode. |
| **Bounce rate** | The share of visitors who opened one page and left. Visitors mode. |

Each number is compared with the period before (7, 30 or 90 days), and you can chart it per day. Below are the top pages and the views per language. In visitors mode you also get the pages visits start on, sources (the site that linked to you, or the campaign in a link's `utm_source` or `ref` parameter, "Direct" when there is none), devices, browsers and operating systems, and *On the site now*, which counts visitors active in the last five minutes.

## Settings

**Settings → Analytics**:

| Setting | |
|---|---|
| **Count visits** | Off stops counting; the numbers collected so far stay. |
| **What to count** | See above. |
| **Wait for consent** | Visitors mode only. |
| **Paths not to count** | Paths or patterns with `*`, e.g. `/drafts/*`. |
| **Keep data for** | Days of history to keep (730 by default); 0 keeps everything. |
| **Lettern URL** | Only for a site published to another domain: the address of this Lettern, which pages report to. |

## How it works

In counts mode, a page ends with `<img src="/api/analytics/view?p=/pricing">`. The endpoint always answers with the same 1×1 GIF and `Cache-Control: no-store`, counted or not, so it reveals nothing. It reads no session and counts only paths that exist, with a same-origin `Sec-Fetch-Site` header when the browser sends one. Its rate limit is one bucket of 600 a minute for everybody, because a key per visitor would mean storing a hash of their address. Past the limit a view isn't counted.

In visitors mode, the script posts to `/api/analytics/hit` after the page loads. Lettern keeps one row per visitor and day and daily totals per page; the endpoint is rate-limited per address and accepts views from the site's own pages only.

Agents and the API read the same numbers through the `analytics/summary` and `analytics/breakdown` abilities (permission `analytics.view`, which editors have by default). In counts mode, numbers it can't know are `null`, and breakdowns other than `pages` and `languages` answer `{"unavailable": "mode"}`. A plugin with pages of its own that aren't entries lets them be counted through the `analytics.known-path` filter.

For development, `php cms analytics:demo` fills an empty site with made-up traffic for the pages it has (`--days=120`, `--fresh` to replace what is there). It refuses to run in production.
