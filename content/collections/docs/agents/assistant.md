---
id: 01m5wn8r9bcb1yamdddxk5erm8
title: Assistant
position: 5
group: 'Agents'
description: Claude inside the admin. It builds, writes and fixes things with the same abilities you use, and asks before it deletes anything.
---
## Setting up

Add an Anthropic API key under **Settings → Assistant** (stored encrypted), or set `ANTHROPIC_API_KEY` in `.env`. To route requests through an API gateway or proxy, set `ANTHROPIC_BASE_URL` in `.env` (HTTPS only); it cannot be changed from the admin, since every chat would pass through it. Choose the default model for new chats — Claude Opus 5.5 unless you change it — and how much effort it may spend thinking. Anyone can switch models from the picker under the chat box: the choice applies from the next message, stays with that chat, and becomes their starting model for new chats.

The assistant is optional: everything else in Lettern works without it. Until a key is set, **New Chat** shows only to those who can add one, and opens the setup; nobody else sees an assistant they cannot use. If you don't use AI, **Unpin New Chat** on that screen (or **Unpin** on its context menu) puts it under **More**, where it stays one click away.

## Using it

Press `⌘J`, click **New Chat** at the top of the sidebar, or type a request in the command palette (`⌘K`) and press `Enter`. The assistant knows which screen you are on, so "tighten the copy on this page" works.

Chat is a workspace page alongside the CMS. **Chats**, after your pinned items in the sidebar, shows your recent conversations once there are any; **Show more** reveals older ones. Each saved chat has its own URL, so browser back and forward work as expected. Use a CMS link in the sidebar to return to your content. To permanently remove a saved conversation, choose **Delete Chat** from the trash button on its row, its right-click menu or the three-dot menu in its header, then confirm; **Discard Draft** does the same for an unsent new chat. Stop any running reply first.

**New Chat** starts a fresh conversation; an unsent one waits there. `⌘J` does the same after a finished chat, and while you are writing a draft in a chat it returns to that draft and focuses the composer. Empty chats are never saved: a conversation is created only when you send the first message. Drafts stay attached to their chat while you move around the admin in the same browser session; reloading clears unsent drafts. A running reply continues when you visit a CMS screen; selecting another conversation stops listening to the previous reply.

You see what it does as it works: its reasoning summary, every tool call with its input and result, and its answer. Changes appear in the admin immediately.

For overviews, comparisons and next-step choices, replies can include a contextual interface: live plugin widgets, metrics, trends, tables and actions composed for your request. These use the same components as the rest of the admin and remain available when you reopen the chat. Choosing a generated action follows the same permission, approval and audit rules as any other assistant action.

Installed widgets become available automatically. Plugins can also contribute schema-described components through the shared [generative UI SDK](/plugins/generative-ui), powered by json-render.

## Safety

- It acts **as you**: same permissions, same audit log (marked *assistant*).
- It never sees security abilities — tokens, passwords, users and roles.
- **Deleting** anything, and admin-level changes, wait for your approval in the chat. Under **Settings → Assistant** you can require approval for every change instead.
- Site content, form submissions, comments and anything else it reads are treated as data, never as instructions. Once a chat has read such content, every change it wants to make waits for your approval, so text planted by someone else cannot make it act on its own.
- Chats are private to you: nobody else can list, open, continue or delete them, and they are deleted with your account. Titles and histories are encrypted in the database.

## Translation

With the assistant set up, the [languages plugin](/content/languages) can translate pages: only the text is sent, and the result opens as a draft.

## Costs

The assistant uses your API key and Anthropic's pricing. Lettern caches the stable part of every request (instructions, tools, earlier messages), so long conversations stay affordable. Token usage is stored with each conversation.
