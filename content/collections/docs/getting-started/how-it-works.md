---
id: 01m713ans99pec1krzqnpfsq7r
title: How Lettern works
position: 2
description: The handful of ideas everything in Lettern is built on. Five minutes to read, and the rest of the docs will make sense.
---
You don't need to know any of this to edit a page. But once these few ideas click, everything else in Lettern will feel obvious.

## Pages are made of blocks

Everything you see on a page is a **block**: a heading, a paragraph, an image, a button, a row of columns. Blocks can hold other blocks, so a section can hold columns, and each column can hold text and a picture.

You build pages by adding, moving and styling blocks, right on the page. See [Writing](/editing/writing).

## A template frames every page

Most pages share a header, a footer and a layout. That frame is a **template**. It has a spot called *Page content* where each page's own blocks go.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"A template plus your page's content makes the published page.\"><div class=\"cluster\" data-gap=\"sm\"><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\"><span class=\"badge\" data-variant=\"outline\"></span><span class=\"badge\" data-variant=\"outline\">Page content</span><span class=\"badge\" data-variant=\"outline\"></span></div><b class=\"text-label\">Template</b><figcaption>Header, footer, layout</figcaption></figure><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">+</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\"><span class=\"badge\" data-variant=\"solid\" data-color=\"neutral\"></span><span class=\"badge\"></span><span class=\"badge\"></span><span class=\"card\" data-variant=\"flat\"></span></div><b class=\"text-label\">Your page</b><figcaption>What you write</figcaption></figure></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">=</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><span class=\"badge\" data-variant=\"outline\"></span><span class=\"badge\" data-variant=\"solid\" data-color=\"neutral\"></span><span class=\"badge\"></span><span class=\"card\" data-variant=\"flat\"></span><span class=\"badge\" data-variant=\"outline\"></span></div><b class=\"text-label\">Published page</b><figcaption>Fast, plain HTML</figcaption></figure></div></div></figure>"}}
:::

Change the template, and every page that uses it changes. Templates are made of blocks too, so you design them the same way. See [Templates](/design/templates).

## Components are designs you reuse

A **component** is a piece of design you use in many places: a header, a card, a call to action. Edit it once, and every copy updates. See [Components](/design/components).

## The design system keeps it all consistent

Your colors, fonts and spacing live in one place: the **design system**, a theme of a few decisions. Blocks use its names, like *heading-2* or *foreground-muted*, never fixed values, so changing your main color restyles the whole site at once, with every text color checked for contrast. See [Design system](/design/design-system).

## Content lives in collections

Pages are one kind of content. Most sites have others: blog posts, team members, projects, products. Each kind is a **collection**, and you decide which fields it has. Every item in it, each post or each dish, is an **entry**.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"A collection called Dishes defines the fields. Each dish is an entry that fills them in.\"><div class=\"cluster\" data-gap=\"sm\"><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Dishes</b><span class=\"badge\">Price</span><span class=\"badge\">Description</span><span class=\"badge\">Photo</span></div><b class=\"text-label\">Collection</b><figcaption>The fields every dish has</figcaption></figure><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Grilled turbot</span><span class=\"badge\">€34</span></span><hr class=\"divider\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Six oysters</span><span class=\"badge\">€21</span></span><hr class=\"divider\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Lemon tart</span><span class=\"badge\">€9</span></span></div><b class=\"text-label\">Entries</b><figcaption>One for each dish</figcaption></figure></div></div></figure>"}}
:::

Your pages then show those entries in your design: the latest posts on the home page, the full menu on the menu page. Editors only fill in the fields, and the design takes care of itself. See [Collections](/content/collections).

## Publishing turns it into a website

When you publish, Lettern writes each page as a plain HTML file. Visitors get those files directly, which makes your site fast, cheap to host and hard to break. Forms and other live features still work. See [Publishing](/operations/publishing).

## People and AI use the same actions

Everything you can do in Lettern, like creating a page, uploading an image or publishing, is a named action called an **ability**. The admin uses them. So do the built-in assistant, AI tools like Claude or ChatGPT, the API and the command line.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"You in the admin, the assistant, your AI tools, the API and the command line all go through the same abilities to change your site.\"><div class=\"cluster\" data-gap=\"sm\"><div class=\"stack\" data-gap=\"2xs\"><span class=\"badge\" data-variant=\"outline\">You, in the admin</span><span class=\"badge\" data-variant=\"outline\">The assistant</span><span class=\"badge\" data-variant=\"outline\">Your AI tools</span><span class=\"badge\" data-variant=\"outline\">REST API</span><span class=\"badge\" data-variant=\"outline\">Command line</span></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><div class=\"card\" data-variant=\"raised\" data-scheme=\"primary\"><b class=\"text-label\">Abilities</b><small class=\"text-caption\">Checked against your<br>permissions, and logged</small></div></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Your site</b></div></div></div></figure>"}}
:::

That's why AI is safe to use here: an agent can only do what the person behind it is allowed to, and everything it does is logged. See [AI and automation](/agents).

## Built in, or a plugin

Your site's design and publishing, media, menus, email, the block editor, languages, comments, MCP, the assistant and Sync come with Lettern. Forms and SEO are **plugins**. Turn off what you don't need, add what you do from the store. Developers can write their own, with the same tools Lettern's own features use. See [Plugins](/plugins).

## Your site is a folder of files

Settings and content can be stored as plain text files, so a developer can keep the whole site in git, review changes and roll them back. You never have to touch them, but they're there. See [Project structure](/reference/project-structure).
