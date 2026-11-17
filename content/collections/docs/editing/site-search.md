---
id: 01m9a0vyq484cm9875q05j6271
title: Site search
position: 6
description: A search field on any page and a page of results, for sites people come to with a question, like a council’s or a support site.
---
Site Search is a free plugin that adds two blocks: a **Search Field** you can put anywhere, such as in the header or at the top of the home page, and **Search Results**, for the page the field sends people to. Install it from **Plugins**, or with `composer require letterncms/site-search`.

The core's **Search** block opens a search box over the page and suits a small site. Site Search is for sites where most visitors arrive with a task and type it in: results get a page of their own, with a link people can share, and filters by kind of page.

## Add a search field

1. Add a **Search Field** block where people should search, like the header or the first section of the home page.
2. Give it a **Label**, like *Search for a service*. **Show Label** shows it above the field; off, screen readers still read it.
3. Choose the **Button Style**, one of your site's button looks, and a **Size**. **Icon Only Button** shows a magnifying glass instead of the button's words, which screen readers still read.
4. Leave **Results Page** at `/search`, or pick the page that shows the results.

The field works without JavaScript: it is a plain form that opens the results page with what was typed.

## Make the results page

1. Make a page at `/search`, or the address you chose, and add a **Search Results** block. A Search Field above it shows what was searched for, ready to change.
2. Set the words it says, if you like: when nothing was typed, when nothing was found, and how many results there are, with `{count}` and `{query}` in them.
3. **Show Filters** lets people narrow the results by kind of page, such as *Service* or *News*, with how many of each there are. The kind is the name of a page's collection, such as *Service* for Services.

Each result shows its kind, its title as a link, its date for a dated collection such as news, and a short extract with the words found marked. Twenty show at first, and **Show More Results** adds the next ones and moves to the first new one.

Search finds every word typed, in any order, ignoring accents, and finds the start of a word, so *recycl* finds *recycling*. Titles count most, then the words a page was given to be found by, then its headings, its summary and its text. The results need JavaScript; without it, the page says so and points people to your menu.

## Words people search for

People don't always use your words. Add a field named **keywords** to a collection, a text field or a list, and fill it with other words for the same thing: *bin, rubbish, garbage* for a page about waste collection. Search finds the page by them.

## For developers

### The blocks

```markdown
::: site-search/form {"props":{"label":"Search the site","show_label":true,"button_style":"primary","size":"lg","results_page":"/search"}}
:::

::: site-search/results {"props":{"heading_level":"2","per_page":20,"show_filters":true}}
:::
```

`site-search/form` takes `label`, `show_label`, `placeholder`, `button_label`, `button_style` (a site button look, written as `btn-<style>`), `icon_only`, `size` (`sm`, `md`, `lg`) and `results_page`. It renders a `form` with `role="search"` that sends `q`.

`site-search/results` takes `heading_level` (`2` to `4`, the level of each result's title), `per_page`, `show_filters`, `filters_label`, the texts `no_query`, `none`, `one`, `many`, `all_label`, `no_script` and `more_label`, and `more_style`. It reads `q` and `kind` from the address, so a filtered search has its own link: `/search?q=parking&kind=Service`.

### The index

Both read the `/search.json` index the site publishes. The plugin adds three things to each page in it through the core's `site.search.record` filter: `kind` (the collection's singular name), `date` for dated collections, and `keywords`. A plugin of your own can change records with the same filter.
