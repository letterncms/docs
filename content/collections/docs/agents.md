---
id: 01m5wn8r8sh9fggf99x1e0zshy
title: 'AI and automation'
position: 6
description: 'Build and edit your site with AI: the assistant in the admin, your own AI tools, the API and the command line.'
---
Lettern is made to work with AI. Ask the assistant in the admin to build a page, connect Claude or ChatGPT to your site, or let a script publish for you. Each of them can do only what the person behind it is allowed to, and every change is logged.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"You in the admin, the assistant, AI tools like Claude, ChatGPT and Cursor, the REST API and the command line all go through the same abilities to change your site.\"><div class=\"cluster\" data-gap=\"sm\"><div class=\"stack\" data-gap=\"2xs\"><span class=\"badge\" data-variant=\"outline\">You, in the admin</span><span class=\"badge\" data-variant=\"outline\">The assistant</span><span class=\"badge\" data-variant=\"outline\">Claude, ChatGPT, Cursor</span><span class=\"badge\" data-variant=\"outline\">REST API</span><span class=\"badge\" data-variant=\"outline\">Command line</span></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><div class=\"card\" data-variant=\"raised\" data-scheme=\"primary\"><b class=\"text-label\">Abilities</b><small class=\"text-caption\">Checked against your<br>permissions, and logged</small></div></div><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Your site</b></div></div></div></figure>"}}
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
