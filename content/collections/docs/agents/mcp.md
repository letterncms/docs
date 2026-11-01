---
id: 01m5wn8r8wb77x2hgt09w7ey1k
title: MCP
position: 4
group: 'Agents'
description: Connect Claude, ChatGPT, Cursor or any MCP client to your site. Agents get your abilities as tools, your design system as context, and prompts that know how to build pages.
---
Every Lettern site is a [Model Context Protocol](https://modelcontextprotocol.io) server at `/mcp`.

## Connecting

Find your site's address under **Account → Connect an AI agent**. In Claude Code:

```bash
claude mcp add --transport http cms https://your-site.com/mcp
```

Most clients sign in with OAuth: they open a consent screen on your site, you sign in (with two-factor authentication if enabled) and approve. The agent then acts as you, with your permissions. Revoke access any time under **Account → Tokens**.

Clients without OAuth can send a personal access token instead: `Authorization: Bearer cms_…`. Give tokens narrow **scopes** — ability patterns like `entries/*`, or `read` for read-only access.

## What agents get

**Tools** — every ability you may run that is exposed to MCP, named with a dot (`entries.create`, `design.update`). Security-sensitive abilities — creating tokens, changing passwords, managing users and roles — are never offered to agents.

**Resources** — context to plan with: `cms://collections` (content types and their schemas), `cms://site/design` (the design system: tokens, fonts, element styles), `cms://blocks` (how to compose pages, templates and components — the node model, styles, bindings, interactions and animations, with worked examples), `cms://forms`, `cms://navigation`, `cms://languages` and more from plugins.

**Prompts** — ready-made workflows: *Build a page* from a brief, *Write a blog post*, *Audit the site* for SEO and GEO problems.

**Instructions** — how to build the Lettern way: read the collections and the design system first, reuse components and templates (`patterns/list`, `templates/list`), style with tokens, give images alt text, publish when done.

## Building with agents

An agent can edit the same block documents as the admin, because the editor works with structured data:

- **Pages** — `entries/create` and `entries/update` with a blocks field, as JSON or as [Block Markdown](/editing/block-markdown).
- **Templates and components** — the same abilities in the `templates` and `components` collections; `entries/publish` makes them live.
- **The design system** — `design/get`, `design/update`, `design/fonts-import`; custom code with `design/code`.
- **What is possible** — `blocks/types` lists every block, style property, state, data source, animation property and script action; `blocks/icons` searches icons.

Try: *“Build a pricing page with three plans using our card component, animate the cards in one by one, and make the yearly/monthly switch work.”*

## Protocol details

Lettern speaks the current stateless revision of MCP (`2026-07-28`: per-request version, `server/discover`) and answers older clients that `initialize` (`2025-11-25`, `2025-06-18`, `2025-03-26`). OAuth follows the MCP authorization spec: protected resource metadata at `/.well-known/oauth-protected-resource`, authorization server metadata, dynamic client registration and client ID metadata documents, PKCE (S256) only, short-lived access tokens with rotating refresh tokens. Requests are rate limited per token.
