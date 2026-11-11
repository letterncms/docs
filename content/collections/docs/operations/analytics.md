---
id: 01m5yz76zg040qnw6kerbpt360
title: Analytics
position: 6
description: See which pages people read, counted on your own server. Page views by default, with visitors, sources and devices if you want them.
---
The Analytics plugin counts visits to your published site on your own server. Nothing goes to another company, and by default nothing is read from the visitor's browser at all.

Open **Analytics** in the sidebar for the numbers, on its **Overview** tab. The **Analytics** card on the dashboard shows the last 30 days at a glance.

## Choose what to count

On the **Settings** tab of **Analytics**, **What to Count** has two options:

| | **Page Views Only** (the default) | **Visitors, Sources and Devices** |
|---|---|---|
| You see | Page views, top pages, languages | Everything, including visitors, where they came from and what they use |
| On the page | One invisible image, no script | A tiny script |
| Read from the browser | Nothing | Where they came from, window width, Do Not Track |
| Kept about visitors | Nothing | A daily code per visitor that can't be traced back, replaced every day |

Visitors mode reads data from the browser and keeps that daily code. Whether that needs your visitors' consent depends on their countries, so check the rules for them. By default it waits for your consent tool to say yes; turn off **Wait for Consent** if you've decided you don't need it. The free [Consent](/operations/consent) plugin is such a tool: with it, counting starts once a visitor accepts analytics.

Going back to page views only deletes the visitor data. Views per page stay.

## Who isn't counted

In both modes, Lettern skips bots, people who ask not to be tracked (**Do Not Track** or **Global Privacy Control**), previews, the editor, and people signed in to the admin. So you and your client don't inflate the numbers. Visitors with an account on the site are counted like anyone else.

## What the numbers mean

| Number | Means |
|---|---|
| **Page Views** | Every page opened. |
| **Visitors** | Different people per day, added up over the period. Visitors mode. |
| **Views per Visit** | Page views divided by visitors. Visitors mode. |
| **Bounce Rate** | The share of visitors who opened one page and left. Visitors mode. |

Choose 7, 30 or 90 days. Each number is compared with the period before, and you can chart it per day. Below are the **Top Pages** and the views per language.

Visitors mode adds the **Entry Pages** where visits start, **Sources** (the site that linked to you, the campaign in a link's `utm_source` or `ref`, or "Direct"), devices, browsers and operating systems, and how many people are on the site now.

## Settings

All on the **Settings** tab of **Analytics**. Save from the bar at the bottom. The rest show while **Count Visits** is on:

| Setting | |
|---|---|
| **Count Visits** | Off stops counting. The numbers collected so far stay. |
| **What to Count** | See above. |
| **Wait for Consent** | Visitors mode only. |
| **Paths Not to Count** | Paths, or patterns with `*`, like `/drafts/*`. |
| **Keep Visits For** | In days, 730 by default. 0 keeps them forever. |
| **Reporting Address** | Only for a site hosted somewhere other than the admin: the address of this Lettern, which pages report to. |

## For developers

### Page views only

A page ends with `<img src="/api/analytics/view?p=/pricing">`, with the path written in at build. The endpoint always answers with the same 1×1 GIF and `Cache-Control: no-store`, counted or not, so it reveals nothing. It reads no session, counts only paths that exist, and requires a same-origin `Sec-Fetch-Site` header when the browser sends one. The IP address and browser string are read in memory to skip bots, then dropped. Its rate limit is one bucket of 600 a minute for everybody, because a key per visitor would mean storing a hash of their address. Past the limit a view isn't counted. Lettern keeps views per day and path.

### Visitors, sources and devices

A few hundred bytes of script post the path, referrer, campaign and window width to `/api/analytics/hit` after the page loads. The endpoint is rate-limited per address and accepts views from the site's own pages only. The IP address and browser string are hashed with a salt that is replaced daily and thrown away. Lettern keeps one row per visitor and day, daily totals per page, and the source, device, browser and operating system. Switching to this mode starts collecting from that day; switching back deletes the visitor data and its salt.

The consent signal is `window.cmsConsent = { analytics: true }` set before the page's script runs, or a `cms:consent` event on `document` with `detail: { analytics: true }`. The [Consent](/operations/consent#the-consent-signal) plugin gives both. Web server logs are separate from all of this, and are your host's matter.

### Staff aren't counted

When someone with admin access signs in, Lettern sets an HTTP-only `cms_staff` cookie. Nothing on a page reads it; the endpoints use it to skip the visit.

### Abilities and hooks

Agents and the API read the same numbers through `analytics/summary` and `analytics/breakdown`, with `analytics.view`, **View Site Analytics** in **Roles** (Editors have it by default). In page-views mode, numbers it can't know are `null`, and breakdowns other than `pages` and `languages` answer `{"unavailable": "mode"}`. A plugin with pages of its own that aren't entries lets them be counted through the `analytics.known-path` filter.

### Demo data

`php cms analytics:demo` fills an empty site with made-up traffic for the pages it has (`--days=120`, `--fresh` to replace what's there). It refuses to run in production.
