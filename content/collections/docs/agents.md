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

Start with the [assistant](/agents/assistant): it answers in the [workspace](/getting-started/workspace), one press of `⌘J` away.

## For developers

Every way in validates input against the ability's schema, checks the same permissions and writes to the same audit log. They differ in how they sign in:

| Way in | Signs in with |
|---|---|
| The admin | A session, CSRF-protected |
| [Assistant](/agents/assistant) | The person's admin session |
| [MCP](/agents/mcp) | OAuth 2.1, or a personal access token |
| [REST API](/agents/rest-api) | A personal access token |
| [Command line](/agents/cli) | Shell access, with full rights |
