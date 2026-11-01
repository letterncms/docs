---
id: 01m5wn8r8sh9fggf99x1e0zshy
title: API and agents
position: 6
description: One set of actions — abilities — behind the admin, the REST API, the command line, MCP and the built-in assistant.
---
Lettern was designed so that software can work with a site as well as people can. Every action is an [ability](/agents/abilities), and every way into Lettern calls abilities:

| Way in | Who it is for | Authentication |
|---|---|---|
| The admin | People | Session, CSRF-protected |
| [REST API](/agents/rest-api) | Integrations, scripts, front ends | Personal access tokens |
| [MCP](/agents/mcp) | Claude, ChatGPT, Cursor and other agents | OAuth 2.1 or tokens |
| [Assistant](/agents/assistant) | People, inside the admin | Their session |
| [CLI](/agents/cli) | Developers, deploy scripts | Shell access |

Whichever way an action comes in, it is validated against the same schema, checked against the same permissions, and written to the same audit log.
