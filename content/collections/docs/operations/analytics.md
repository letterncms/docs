---
id: 01m5yz76zg040qnw6kerbpt360
title: Analytics
position: 6
description: See who reads your site, where they come from and what they do, counted on your own server. Page views by default; visitors, goals, funnels, page speed and Google Search if you want them.
---
The Analytics plugin counts visits to your published site on your own server. Nothing goes to another company, no cookie is set, and by default nothing is read from the visitor's browser at all.

![Analytics: visitors, visits and page views against the month before, the chart, and where visits come from.](/media/screens/operations-analytics.webp)

Open **Analytics** in the sidebar for the numbers. The **Analytics** card on the dashboard shows the last 30 days at a glance, and **Customize** adds three more: **On the Site Now**, **Top Pages** and **Google Search**. Each page in the editor has an **Analytics** tab in its side panel with how it did in the last 30 days.

## Choose what to count

On the **Settings** tab of **Analytics**, **What to Count** has two options:

| | **Page Views Only** (the default) | **Visitors, Sources and Devices** |
|---|---|---|
| You see | Page views, top pages, languages | Everything below |
| On the page | One invisible image, no script | A small script |
| Read from the browser | Nothing | Where they came from, window width, time zone, how long and how far they read, how fast the page was, Do Not Track |
| Kept about visitors | Nothing | A daily code per visitor that can't be traced back, replaced every day |

Visitors mode reads data from the browser and keeps that daily code. Whether that needs your visitors' consent depends on their countries, so check the rules for them. By default it waits for your consent tool to say yes; turn off **Wait for Consent** if you've decided you don't need it. The free [Consent](/operations/consent) plugin is such a tool: with it, counting starts once a visitor accepts analytics.

Going back to page views only deletes the visitor data. Views per page stay.

## Who isn't counted

In both modes, the CMS skips bots (search engines' and AI companies' crawlers among them), people who ask not to be tracked (**Do Not Track** or **Global Privacy Control**), previews, the editor, and people signed in to the admin. So you and your client don't inflate the numbers. Visitors with an account on the site are counted like anyone else.

## The Overview

Pick the period at the top right: the last 30 minutes (live), today or yesterday by the hour, the last 7, 30 or 90 days, the last 12 months by the month, or any two dates. Every number is compared with the period before, and the chart draws the period before as a dashed line behind the one on view. Press a number to chart it.

| Number | Means |
|---|---|
| **Visitors** | Different people per day, added up over the period. |
| **Visits** | Times people came. A visit ends after half an hour without a page or a click. |
| **Page Views** | Every page opened. |
| **Views per Visit** | Page views divided by visits. |
| **Bounce Rate** | The share of visits of one page, with no click on a link, a download or a form. |
| **Visit Duration** | How long a visit's pages were in front of the visitor, on average. A tab in the background doesn't count. |
| **Time on Page** | The same for one page, when you narrow the report to it. |
| **Scroll Depth** | How far down people got on a page, on average. |

Below the chart:

- **Sources**: **Channels** (search engines, AI assistants such as ChatGPT, Perplexity, Claude, Gemini and Copilot, social networks, email, paid ads, other websites and campaigns), **Sources** (the site that linked to you, or "Direct") and **Campaigns** (from a link's `utm_campaign`).
- **Pages**: the **Top Pages** with their time on page and scroll depth, the **Entry Pages** visits start on, and the **Exit Pages** they end on.
- **Countries**, from the visitor's time zone: no address is looked up.
- **Devices**: the kind of device, the browser and the operating system.
- **Goals**: see below.

### Narrow the report

Press any row, a source, a page, a country, a goal, and every number, the chart and every list show only those visits: "AI Assistants" shows what people sent by AI answers read, "/pricing" shows who read the pricing page and where they came from. The filters show at the top; remove one with its ×. They're in the page's address, so you can bookmark or send a report, and **Back** takes the last one off.

## Goals

A goal is something you want visitors to do. Every event below is a goal by its name, with how many visitors reached it, how often, and the **Conversion Rate**: the share of visitors who did. Press a goal to see who reached it, and what its events carried, such as which links were clicked or which files downloaded.

- **Outbound Link**, **File Download** and **Form Sent** are counted by themselves: clicks on links to other sites, downloads of files (PDF, documents, archives, audio and video) and forms sent. Turn them off with **Count Links, Downloads and Forms**. A form's contents are never read.
- **Page Not Found** is a visit to an address the site doesn't have, with that address, so you can find broken links.
- **Goal Pages** in the settings turn a page into a goal: a name such as "Signed Up" and a page such as `/thank-you`, or `/welcome/*` for every page under it.
- Your site's own events, see [For developers](#events-of-your-own).

## Journeys

The **Journeys** tab (visitors mode) shows how visits move through the site.

- **Funnels**: add one under **Funnels** in the settings, with a name and its steps in order, each a page (`/pricing`) or a goal's name (`Signup`). The tab shows how many visitors took each step within one visit, and how many dropped off at each.
- **Common Paths**: the routes visits of two pages or more take most, two, three or four pages long. Narrow the report to one page and it shows where its visitors came from and where they went next.

## Search

The **Search** tab is about how people find the site.

- **Google Search**, from Google Search Console: clicks, impressions, click-through rate and average position, the searches people found the site with, the pages Google showed, and **Close to the Top**: searches the site shows up for at positions 4 to 20, most shown first. Those are where a better page brings more visitors soonest. Narrow the report to a page to see its searches only. Google is a day or two behind.
- **AI Assistants**: how many visitors AI answers sent, which assistants, and the pages they landed on.
- **Page Speed**: how fast the pages were for your visitors, measured in their browsers: the Core Web Vitals Google ranks pages by. **Loading** is Largest Contentful Paint, **Responding** is Interaction to Next Paint and **Steadiness** is Cumulative Layout Shift. Each is what 3 in 4 visits did at least as well as, and is rated as Google rates it: good up to 2.5 s, 200 ms and 0.1, poor above 4 s, 500 ms and 0.25. The pages that need it most come first; a page is rated once 10 visits measured it.

### Connect Search Console

The CMS reads Search Console as a Google Cloud service account, so no Google sign-in is kept on your site:

1. In the [Google Cloud console](https://console.cloud.google.com/), make a project (or use one), and turn on the **Google Search Console API** for it.
2. Under **IAM & Admin → Service Accounts**, make a service account. Under its **Keys**, add a key of type JSON. A file downloads.
3. In [Search Console](https://search.google.com/search-console), open your site's property, then **Settings → Users and permissions → Add user**: the service account's email address (`…@….iam.gserviceaccount.com`), with **Restricted** permission.
4. In the CMS, on the **Settings** tab of **Analytics**, paste the whole file into **Service Account Key** and save.

The key is kept encrypted, outside the site's settings files, and can be set with the environment variable `CMS_ANALYTICS_SEARCH_KEY` instead. The CMS finds the property for the site's address itself; if yours is another one, name it in **Search Console Property**: `sc-domain:example.com` for a domain property, `https://example.com/` for an address one. If something is wrong, the **Search** tab says what: the key, or access to the property.

## Settings

All on the **Settings** tab of **Analytics**. Save from the bar at the bottom. The rest show while **Count Visits** is on:

| Setting | |
|---|---|
| **Count Visits** | Off stops counting. The numbers collected so far stay. |
| **What to Count** | See above. |
| **Wait for Consent** | Visitors mode only. |
| **Count Links, Downloads and Forms** | Visitors mode only. On by default. |
| **Paths Not to Count** | Paths, or patterns with `*`, like `/drafts/*`. |
| **Keep Visits For** | In days, 730 by default. 0 keeps them forever. |
| **Reporting Address** | Only for a site hosted somewhere other than the admin: the address of this CMS, which pages report to. |
| **Goal Pages** | See [Goals](#goals). |
| **Funnels** | See [Journeys](#journeys). Visitors mode only. |
| **Service Account Key** | See [Connect Search Console](#connect-search-console). |
| **Search Console Property** | Only when the CMS can't find it itself. |

## For developers

### Page views only

A page ends with `<img src="/api/analytics/view?p=/pricing">`, with the path written in at build. The endpoint always answers with the same 1×1 GIF and `Cache-Control: no-store`, counted or not, so it reveals nothing. It reads no session, counts only paths that exist, and requires a same-origin `Sec-Fetch-Site` header when the browser sends one. The IP address and browser string are read in memory to skip bots, then dropped. Its rate limit is one bucket of 600 a minute for everybody, because a key per visitor would mean storing a hash of their address. Past the limit a view isn't counted. The CMS keeps views per day and path.

### Visitors mode

A script of about 3 KB, the same on every page, posts to `/api/analytics/hit`: the page view after the page loads (path, referrer, `utm_source` or `ref`, `utm_medium`, `utm_campaign`, whether the address has an ad click id, the window width and the time zone), then as the page is hidden the time it was in front of the visitor, how far they scrolled and its Core Web Vitals, and any events. It stores nothing in the browser. Its settings are the script element's attributes, so the site's content security policy needs one hash for it. The endpoint is rate-limited per address and accepts reports from the site's own pages only.

The IP address, the browser string and the site's host are hashed with a salt that is replaced daily and thrown away. Of the referrer only the site's name is kept. The CMS keeps visits (with the source, channel, campaign, country, device, browser and operating system), the pages viewed in them with their time, scroll depth and speed, and their events. Switching to this mode starts collecting from that day; switching back deletes the visitor data and its salt.

The consent signal is `window.cmsConsent = { analytics: true }` set before the page's script runs, or a `cms:consent` event on `document` with `detail: { analytics: true }`. The [Consent](/operations/consent#the-consent-signal) plugin gives both. Web server logs are separate from all of this, and are your host's matter.

### Events of your own

On a published page, count an event with a name and up to 10 properties of short text:

```js
window.cmsAnalytics.track('Signup', { plan: 'Pro' })
```

Or give an element the event's name, and each click on it counts:

```html
<a href="/signup" data-cms-event="Signup" data-cms-event-plan="Pro">Start free</a>
```

A plugin counts an event of its own, a sale or a confirmed sign-up, through the core's hooks, without depending on Analytics: `cms()->hooks()->dispatch('analytics.track', 'Purchase', ['plan' => 'Pro'], '/pricing')`. Such events belong to no visit, so they add to how often a goal was reached, not to its visitors.

### Staff aren't counted

When someone with admin access signs in, the CMS sets an HTTP-only `cms_staff` cookie. Nothing on a page reads it; the endpoints use it to skip the visit.

### Abilities and hooks

Agents (over MCP), the REST API, the command line and other plugins read the same numbers through abilities, with `analytics.view`, **View Site Analytics** in **Roles** (Editors have it by default). Each takes a `period` (`realtime`, `today`, `yesterday`, `7d`, `30d`, `90d`, `12mo`, or `custom` with `from` and `to`) and `filters`, a list of `{"dimension": "source", "op": "is", "value": "Google"}`: dimensions `page`, `goal`, `entry`, `exit`, `channel`, `source`, `medium`, `campaign`, `country`, `device`, `browser` and `os`; ops `is`, `is_not` and `contains`; `*` in a page for anything and `null` for none. They answer with totals only, never with one visitor.

| Ability | Answers with |
|---|---|
| `analytics/summary` | The numbers of the Overview for the period and the one before, a row per step, and who is on the site now. `compare: true` adds the period before step by step. |
| `analytics/breakdown` | Visitors per `pages`, `entries`, `exits`, `channels`, `sources`, `campaigns`, `countries`, `devices`, `browsers`, `os`, `languages`, `goals` or `props` (the properties of the goal filtered on). |
| `analytics/funnel` | A funnel of the settings by its name, or `steps` given, step by step. |
| `analytics/paths` | The common paths, or a `page`'s before and after. |
| `analytics/vitals` | Page speed for the site and per page. |
| `analytics/search` | Search Console: `summary`, `queries`, `pages`, `countries`, `devices`, `opportunities` or `status`; narrowed to a `page` or a `query`. |
| `analytics/goals` | The goal pages and funnels of the settings. |
| `analytics/track` | Counts an event from outside the pages. Needs `analytics.track`, **Record Analytics Events** (Administrators have it). |

In page-views mode, numbers it can't know are `null`, filters other than pages and breakdowns other than `pages`, `languages` and `goals` answer `{"unavailable": "mode"}`. A plugin with pages of its own that aren't entries lets them be counted through the `analytics.known-path` filter.

### Demo data

`php cms analytics:demo` fills an empty site with made-up traffic for the pages it has: visits, goals, countries and page speed (`--days=120`, `--fresh` to replace what's there). It refuses to run in production.
