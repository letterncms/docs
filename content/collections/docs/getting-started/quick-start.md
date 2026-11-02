---
id: 01m5wmrf5pxyen1ww2w88nffby
title: Quick start
position: 2
group: 'Set up'
description: From an empty install to a designed, published page in ten minutes.
---
This walk-through uses the admin. Every step is also an ability, so you could do the same from the [CLI](/agents/cli), the [REST API](/agents/rest-api) or an [AI agent](/agents/mcp).

## Finding your way

The sidebar holds what you open every day: **New Chat**, **Dashboard** and **Analytics**, then your content — *Pages*, *Blog*, *Media* and *Forms*. Hide it with `⌘\` when you want the room; it stays that way until you bring it back. Everything else is one click away under **More** (globals, menus, templates, components, the design system, redirects). Pin what you use often from there, hover a row to unpin it, right-click it to move it or open it in a new tab, drag rows to reorder them, or open **Customize Sidebar…** to arrange everything at once. Your sidebar is your own; an admin can make theirs the default for everyone.

**Settings** (the gear next to your name, or `⌘⇧,`) turns the sidebar into the settings list: your account, the site's settings and administration — users, roles, collections, languages, modules and the audit log. **Back** or `Esc` returns you to where you were. `⌘K` finds any screen, setting, entry or command.

The assistant is optional. Lettern works fully without an API key: **New Chat** leads admins to set one up, and if you don't use AI, **Unpin New Chat** puts it away under More.

## 1. Model your content

With the Site plugin on, a new site starts from its starter kit: *Pages* (a tree with a Home, About and Blog page) and *Blog* (`posts`), templates, a header and a footer, and a main menu. Open **Settings → Collections** to change them or add your own — say *Services* with a **Blocks** field for the body and any additional structured fields you need. Collections are saved as YAML in `content/collections/`, so you can commit them.

## 2. Write and shape a page

Open **Pages** and press **New page** (or `C`). Edit text in the rendered page, rest the pointer between blocks and press `+` to add text, media, layouts and data blocks, and use **Outline** to navigate. Select a block for the shared **Design**, **Content** and **Interact** inspector. Posts, templates and components use this same workspace. The site renderer shows the real layout while you work. Changes save as you go; **Preview** checks interactions without editing controls.

## 3. Shape the design system

Open **Design System** (under **More** — pin it while you build) to edit the tokens — colors, fonts, sizes, spacing — with a live preview. Every block uses these tokens, so one change restyles the whole site. Open **Templates** or **Components** to change the frame around pages or the header and footer; they use the same block editor.

## 4. Publish

Press **Publish**. Lettern renders the page with its template to `public/`, updates the sitemap, `llms.txt` and the page's Markdown twin, and the change is live — no deploy step, no cache to clear.

## 5. Let an agent help

Press `⌘J` to open the assistant and ask it to *"add a pricing section with three plans"*. It uses the same abilities you do and asks before deleting anything. To work from your own AI tools instead, connect them over [MCP](/agents/mcp).
