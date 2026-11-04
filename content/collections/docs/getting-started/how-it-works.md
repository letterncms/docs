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

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A template plus your page's content makes the published page.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-mock\"><i class=\"docs-mock__bar\"></i><i class=\"docs-mock__slot\">Page content</i><i class=\"docs-mock__bar\"></i></div><b>Template</b><small>Header, footer, layout</small></div><span class=\"docs-fig__op\">+</span><div class=\"docs-fig__step\"><div class=\"docs-mock\"><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__l docs-mock__l--short\"></i><i class=\"docs-mock__img\"></i></div><b>Your page</b><small>What you write</small></div><span class=\"docs-fig__op\">=</span><div class=\"docs-fig__step\"><div class=\"docs-mock docs-mock--live\"><i class=\"docs-mock__bar\"></i><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__img\"></i><i class=\"docs-mock__bar\"></i></div><b>Published page</b><small>Fast, plain HTML</small></div></div></figure>"}}
:::

Change the template, and every page that uses it changes. Templates are made of blocks too, so you design them the same way. See [Templates](/design/templates).

## Components are designs you reuse

A **component** is a piece of design you use in many places: a header, a card, a call to action. Edit it once, and every copy updates. See [Components](/design/components).

## The design system keeps it all consistent

Your colors, fonts and spacing live in one place: the **design system**. Blocks use its values instead of fixed ones, so changing your main color restyles the whole site at once. See [Design system](/design/design-system).

## Content lives in collections

Pages are one kind of content. Most sites have others: blog posts, team members, projects, products. Each kind is a **collection**, and you decide which fields it has. Every item in it, each post or each dish, is an **entry**.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A collection called Dishes defines the fields. Each dish is an entry that fills them in.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Dishes</b><span class=\"docs-card__field\">Price</span><span class=\"docs-card__field\">Description</span><span class=\"docs-card__field\">Photo</span></div><b>Collection</b><small>The fields every dish has</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Grilled turbot</span><em>€34</em></div><div class=\"docs-card docs-card--row\"><span>Six oysters</span><em>€21</em></div><div class=\"docs-card docs-card--row\"><span>Lemon tart</span><em>€9</em></div></div><b>Entries</b><small>One for each dish</small></div></div></figure>"}}
:::

Your pages then show those entries in your design: the latest posts on the home page, the full menu on the menu page. Editors only fill in the fields, and the design takes care of itself. See [Collections](/content/collections).

## Publishing turns it into a website

When you publish, Lettern writes each page as a plain HTML file. Visitors get those files directly, which makes your site fast, cheap to host and hard to break. Forms and other live features still work. See [Publishing](/operations/publishing).

## People and AI use the same actions

Everything you can do in Lettern, like creating a page, uploading an image or publishing, is a named action called an **ability**. The admin uses them. So do the built-in assistant, AI tools like Claude or ChatGPT, the API and the command line.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"You in the admin, the assistant, your AI tools, the API and the command line all go through the same abilities to change your site.\"><div class=\"docs-fig__fan\"><div class=\"docs-fig__from\"><span>You, in the admin</span><span>The assistant</span><span>Your AI tools</span><span>REST API</span><span>Command line</span></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__hub\"><b>Abilities</b><small>Checked against your permissions, and logged</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__to\"><b>Your site</b></div></div></figure>"}}
:::

That's why AI is safe to use here: an agent can only do what the person behind it is allowed to, and everything it does is logged. See [AI and automation](/agents).

## Built in, or a plugin

Media, menus, email, the block editor, languages, comments and MCP come with Lettern. Your site's design and publishing, forms, SEO and the assistant are **plugins**. Turn off what you don't need, add what you do from the store. Developers can write their own, with the same tools Lettern's own features use. See [Plugins](/plugins).

## Your site is a folder of files

Settings and content can be stored as plain text files, so a developer can keep the whole site in git, review changes and roll them back. You never have to touch them, but they're there. See [Project structure](/reference/project-structure).
