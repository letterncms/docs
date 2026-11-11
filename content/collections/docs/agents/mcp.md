---
id: 01m5wn8r8wb77x2hgt09w7ey1k
title: Connect AI tools
position: 1
description: Work on your site from Claude, ChatGPT, Cursor or any other AI tool that speaks MCP. It takes a minute to connect.
---
Connect Claude, ChatGPT, Cursor or another AI tool to your site, and ask it to build pages, write posts or fix your SEO from the app you already use. It signs in as you, can do only what you can, and every change it makes is in the audit log.

These tools connect through **MCP**, the Model Context Protocol: an open standard for letting AI tools use other software. Every Lettern site is an MCP server: it comes with Lettern, on from the start.

![The Account screen, with your site's server URL ready to copy.](/media/screens/agents-connect.webp)

## Connect your AI tool

### 1. Copy your server URL

Click your name at the bottom of the sidebar and choose **Account**. Under **Agents**, press **Copy** next to the **MCP Server URL**. It's your site's address followed by `/mcp`:

```text
https://your-site.com/mcp
```

You can also press `⌘K` and choose **Connect an AI Agent (MCP)** to go straight there.

### 2. Add it to your tool

::: tabs {"props":{"label":"AI tools"}}
:::: tab-panel {"props":{"label":"Claude"}}
In the Claude app or on claude.ai, open **Settings → Connectors** and choose **Add custom connector**. Give it a name, such as your site's, paste the server URL and press **Add**. Then press **Connect** next to it.
::::

:::: tab-panel {"props":{"label":"ChatGPT"}}
In ChatGPT's settings, turn on developer mode (under **Apps**, in the advanced settings), then create a new app or connector. Give it a name, paste the server URL, and choose OAuth to sign in.
::::

:::: tab-panel {"props":{"label":"Cursor"}}
Add your site to `.cursor/mcp.json` in your project, or to `~/.cursor/mcp.json` for every project:

```json
{
  "mcpServers": {
    "my-site": { "url": "https://your-site.com/mcp" }
  }
}
```

Then open Cursor's MCP settings and sign in to the server when it asks.
::::

:::: tab-panel {"props":{"label":"Claude Code"}}
Run this in your terminal. It's under **Agents** on the Account screen too, ready to copy:

```bash
claude mcp add --transport http cms https://your-site.com/mcp
```

Then type `/mcp` in Claude Code, pick `cms` and sign in.
::::

:::: tab-panel {"props":{"label":"Another tool"}}
Add a remote MCP server (sometimes called HTTP or streamable HTTP) with the server URL. Most tools sign in with OAuth, the next step. If yours can't, [use a token](#use-a-token-instead).
::::
:::

### 3. Approve the connection

Your tool opens a page on your site. Sign in if you aren't already (with your two-factor code, if you use one). The page asks whether to connect the tool and shows what it will be able to do:

- **Full Access**: everything you can do in the admin.
- **Read Only**: it can look, but never change anything.

Press **Connect**, and you're back in your tool, connected. Your account needs access to the admin to connect a tool.

## Try it

Ask your tool for something real, for example:

> Build a pricing page with three plans using our card component, animate the cards in one by one, and make the yearly/monthly switch work.

Lettern tells it to read your collections and design system first, so what it builds uses your fonts, colors and components. Most tools also list your site's skills as ready-made prompts: **Build a Page**, **Write a Blog Post**, **Audit the Site**, **Proofread** and **Adjust the Design**.

## See and revoke connections

Every connected tool is listed under **Agents** on your Account screen with when it was last active, and under **API Tokens** below it, named after the tool, such as *MCP: Claude*. Choose **Revoke** in its menu there to disconnect it at once.

A connection stays signed in while you use it. One that goes unused for 180 days has to connect again.

## Use a token instead

For a tool that can't sign in with OAuth, create a token and send it with every request.

1. On your Account screen, under **API Tokens**, press **New Token**.
2. Give it a name, choose its **Access** (**Full Access**, **Read Only** or **Content Only**) and when it **Expires**, such as **30 Days** or **1 Year**, then press **Create Token**.
3. Copy the token: it's shown only once. Your tool sends it as a header:

```text
Authorization: Bearer cms_…
```

A token acts as you. See [REST API](/agents/rest-api) for scopes.

## What agents get

**Tools**: every ability you may run that is exposed to MCP, named with a dot (`entries.create`, `design.update`). Security-sensitive abilities, like creating tokens, changing passwords, managing users and roles, or changing what a role may do, are never offered to agents.

**Resources**: context to plan with. `cms://collections` (content types and their fields), `cms://collections/{handle}/schema` (the JSON Schema an entry of one collection must follow, listed by `resources/templates/list`), `cms://site/design` (the design system: tokens, fonts, element styles), `cms://blocks` (how to compose pages, templates and components: the block model, styles, bindings, interactions and animations, with worked examples), `cms://site/code` (the design's [scripts and styles](/design/design-system#custom-css-and-javascript) and where they load), `cms://globals`, `cms://media`, `cms://navigation`, `cms://languages`, and more from plugins: `cms://forms` from Forms, `cms://brevo` from Brevo, `cms://webhooks/events` from Webhooks. `resources/list` names the ones on your site.

**Prompts**: the site's [skills](/agents/assistant#use-a-skill), ready-made workflows like *Build a page* from a brief, *Write a blog post* and *Audit the site* for SEO and GEO problems, plus whatever plugins add.

**Instructions**: how to build the Lettern way. Read the collections and the design system first, reuse components and templates (`components/list`, `templates/list`), style with tokens, give images alt text, and publish when done.

## For developers

### Building with agents

The editor works with structured data, so an agent edits the same block documents as the admin:

- **Pages**: `entries/create` and `entries/update` with a blocks field, as JSON or as [Block Markdown](/reference/block-markdown).
- **Templates and components**: the same abilities, in the `templates` and `components` collections. `entries/publish` makes them live.
- **The design system**: `design/get`, `design/update`, `design/fonts-import`, and custom code with `design-code/set-custom`.
- **What's possible**: `blocks/types` lists every block, style property, state, data source, animation property and script action. `blocks/icons` searches icons.

### Protocol

The server is at `POST /mcp`. It speaks the current stateless revision of MCP (`2026-07-28`: a version per request, `server/discover`) and answers clients that open with `initialize` (`2025-11-25`). Tool names are ability names with a dot instead of the slash. Every tool has an `outputSchema`, and its `structuredContent` is always an object: a list is under `items`, and a string, a number or nothing under `result`. A tool that changes something takes `dryRun: true` and then answers with what it would change instead.

OAuth follows the MCP authorization spec: protected resource metadata at `/.well-known/oauth-protected-resource`, authorization server metadata, dynamic client registration and client ID metadata documents, PKCE (S256) only, and access tokens that last 30 days with rotating refresh tokens that last 180. Requests are rate limited per token.
