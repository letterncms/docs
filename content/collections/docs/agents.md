---
id: 01m5wn8r8sh9fggf99x1e0zshy
title: 'AI and automation'
position: 6
description: 'Build and edit your site with AI: the assistant in the admin, your own AI tools, the API and the command line.'
---
Lettern is made to work with AI. Ask the assistant in the admin to build a page, connect Claude or ChatGPT to your site, or let a script publish for you. Each of them can do only what the person behind it is allowed to, and every change is logged.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"You in the admin, the assistant, AI tools like Claude, ChatGPT and Cursor, the REST API and the command line all go through the same abilities to change your site.\"><div class=\"docs-fig__fan\"><div class=\"docs-fig__from\"><span>You, in the admin</span><span>The assistant</span><span>Claude, ChatGPT, Cursor</span><span>REST API</span><span>Command line</span></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__hub\"><b>Abilities</b><small>Checked against your permissions, and logged</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__to\"><b>Your site</b></div></div></figure>"}}
:::

Behind every button in the admin is a named action, called an [ability](/agents/abilities): create a page, upload an image, publish. The assistant, your AI tools, the API and the command line use exactly the same abilities. So whichever way a change comes in, it gets the same checks, the same permissions and the same entry in the audit log.

Start with the [assistant](/agents/assistant): it answers in the [workspace](/getting-started/workspace), one press of `⌘J` away. To see what an agent of your own does, step by step, read [Build a page with an agent](/agents/build-a-page).

## A new site tells agents how to work on it

Installing a site, with `cms install` or through the setup in the browser, writes an `AGENTS.md` in its folder: the file coding agents such as Claude Code and Cursor read before they touch a project. It is written from the site as installed, so it names only what that site has:

- What the site is, and where content, design and settings live.
- How to find the abilities and try one without writing: `php cms run abilities/list --json`, `collections/schema`, `--dry-run`.
- How to build and check the pages: `php cms build --strict --json` and `php cms links:check`.
- Where the MCP server is.
- The rules that matter: abilities instead of the database, Block Markdown in content files, design tokens instead of fixed values, secrets left alone.
- The collections, modules and plugins that were on when it was written.

From then on the file is yours. It is never written again, and a site that already has one keeps it.

## For developers

Every way in validates input against the ability's schema, checks the same permissions and writes to the same audit log. They differ in how they sign in:

| Way in | Signs in with |
|---|---|
| The admin | A session, CSRF-protected |
| [Assistant](/agents/assistant) | The person's admin session |
| [MCP](/agents/mcp) | OAuth 2.1, or a personal access token |
| [REST API](/agents/rest-api) | A personal access token |
| [Command line](/agents/cli) | Shell access, with full rights |
