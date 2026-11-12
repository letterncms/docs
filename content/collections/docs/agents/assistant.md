---
id: 01m5wn8r9bcb1yamdddxk5erm8
title: Assistant
position: 0
description: Claude, in the workspace. Ask in plain words and watch it build, write and fix things on the page beside you.
---
The assistant is Claude, answering in the [workspace](/getting-started/workspace). Ask it in plain words to build a page, rewrite a section or fix your SEO, and watch the change happen on the page beside the thread. It works as you, with your permissions, and asks before it deletes anything, turns a plugin on or off, or does something hard to undo.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"You ask in plain words. The assistant makes the change on the page, as you. Deleting waits for your go-ahead.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>You</b><span class=\"docs-card__field\">Add our people to the office page</span></div><b>Ask</b><small>In plain words</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-mock docs-mock--live\"><i class=\"docs-mock__h\"></i><i class=\"docs-mock__l\"></i><i class=\"docs-mock__l docs-mock__l--short\"></i><i class=\"docs-mock__img\"></i></div><b>It works</b><small>On the page, as you</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Allow this action?</b><span class=\"docs-card__field\">Delete “Night Shift”</span></div><b>You decide</b><small>Before anything is deleted</small></div></div></figure>"}}
:::

## Set it up

The assistant comes with Lettern, so there's nothing to install. It runs on your own Anthropic API key, so you pay Anthropic directly for what you use.

1. Create an API key at [console.anthropic.com](https://console.anthropic.com), under **API keys**.
2. In the admin, open **Settings**, then **Assistant**, and paste it into **Anthropic API Key**. It's stored encrypted. Save.
3. Press `⌘J` and ask away. Plain words now go to Claude; `/` still runs commands, and **Search for** in `/` still searches without it.

![The assistant's settings: the API key, the models, and when it asks for approval.](/media/screens/agents-assistant-settings.webp)

On the same screen you choose the **Default Model** for new threads (Claude Sonnet 5.5 unless you change it) and its **Effort**: how much it may think before it answers. Sonnet handles everyday site work well; pick Claude Opus 5.5 or Claude Fable 5.1 for harder jobs. The **Model for Small Tasks** names each thread after its first reply, so it's a fast, inexpensive one: Claude Haiku 5.5 unless you change it.

You can also switch models from the picker under the message box. Your choice applies from the next message, stays with that thread, and becomes your starting model for new threads.

::: callout {"props":{"tone":"tip","text":"Not using AI? Lettern works fully without it. Until a key is set, the workspace runs commands and searches, and nothing in it mentions AI. People without the <strong>Use the AI Assistant</strong> permission get the same."}}
:::

## Ask

Click **Chat** in the top bar or **New Chat** in the sidebar, on any screen, or press `⌘J`. You can also press `⌘K`, type your request after the `/` and press `Enter`: words that match no command are asked. The workspace opens ready to type in.

| Press | To |
|---|---|
| `⌘J` | Open or close the workspace |
| `⌘K`, then type and press `Enter` | Ask, when no command matches what you typed |
| `Esc` | Put the workspace away |
| `@` | Attach a page, a file or other context |
| `/` at the start of a line | Use a skill or run a command |

The workspace opens at the right edge of the window, and the page stays open and usable beside it. Whatever the assistant changes shows there as it happens, in the builder too. Links in its replies open in the page next to the thread, so you can keep going. Drag the workspace's left edge to make it wider.

Putting the workspace away doesn't stop a reply: it keeps coming, and **Chat** in the top bar shows when the assistant is working or waiting for your go-ahead.

It also moves the admin for you. Ask *"go to the last edited page"*, *"open the General settings at the site name"* or *"show me the visitors"*, and that screen opens as it answers, at the right tab or field. It can open what it just made, too. Reopening a thread later never moves the page.

The assistant knows what you did in the thread without it: run **New Page**, then ask *"publish it and add it to the main menu"*, and it knows which page.

### Make it bigger, or move it

- **Full Size** grows the workspace over the whole window, with your threads beside it and an address of its own to bookmark. **Back to the Page** returns to the page you came from, just as you left it. Opening anything from the sidebar does the same with that screen.
- **In an editor**, the workspace floats at the right of the canvas, so the inspector stays put and the canvas doesn't move. Drag it by its top bar to wherever suits you.
- **Anywhere else**, **Detach** makes it float the same way, and **Dock Beside the Page** puts it back. Your choice sticks.
- **On a phone**, the workspace fills the screen.

## Show it what you mean

The chips above the message box show what your message will carry. Without you doing anything, that's what you have on view:

- **The page on view.** In an editor, that's the entry as it stands, saved first, so the assistant works on what you see. On any other screen, it's the screen's text. Values in form fields are not part of it.
- **The block selected in the builder.** Select a block with the workspace open, and "rewrite this" means that block.
- **Text you selected on the page.**

Each chip comes off with its ×. To add something else, type `@` or click the **@** chip: a page or post, a file from the library, a global set, the collections or the design system. Keep typing to narrow it down. For a file, the assistant gets its details, not what the image shows.

Something that hasn't changed since your last message isn't sent again. Each message you send shows what it carried; click it to go there.

**Account**, **Users** and the **Audit Log** stay private: they show no chip, and the assistant gets only the address of the screen.

## Use a skill

A skill is a ready-made way of working. Type `/` at the start of a line and pick one, then write the details in your message, or send the skill alone when it needs none.

| Skill | Does |
|---|---|
| `/proofread` | Fixes mistakes and tightens the copy of a page |
| `/build-page` | Designs a complete page from a brief, with your design system and components |
| `/write-post` | Drafts a blog post for you to review |
| `/audit-site` | Checks every published page for SEO, GEO and accessibility problems, and proposes fixes |
| `/adjust-design` | Changes the design system so the site feels a certain way |

You see only the skills you have permission to use, and plugins can add their own.

## Watch it work

You see everything the assistant does, as it does it: a summary of its reasoning, every action it takes with what went in and what came out, and its answer. Changes appear in the admin straight away.

For overviews, comparisons and choices about what to do next, a reply can include a small interface built for your question: live widgets from your plugins, numbers, trends, tables and buttons. They use the same components as the rest of the admin, and they're still there when you reopen the thread. A button in a reply follows the same permission, approval and audit rules as anything else the assistant does.

## Safety

- **It acts as you.** It has your permissions, and its changes go in the audit log as yours, marked *assistant*.
- **It never touches security or access.** Tokens, passwords and two-factor settings are out of its reach, and so are people: it can't create, invite, change or remove users, grant or take away roles, or change what a role may do, even when an administrator asks. People do that themselves, in **Settings**.
- **You approve what matters.** With **Ask Before** set to **Deletes and Admin Changes**, the default, deleting anything and admin-level changes wait for you in the thread: **Allow**, **Decline**, or **Allow All**. Each one says in a sentence what it changes; the action's name under it shows exactly what it sends. Other changes, such as writing a draft, go ahead and show as they happen. To approve every change instead, set **Ask Before** to **Every Change** in the assistant's settings.
- **Content is never an instruction.** Site content, form submissions, comments and anything else it reads are treated as data, the page on view too. Once a thread holds such content (something it read, a search, a list a command brought back), it can still save drafts on its own: nothing there is live until it's published, and the history keeps what was there. Anything else waits for your approval, publishing included, so text planted by someone else can't reach your visitors or do anything you can't undo.
- **Threads are private.** Nobody else can list, open, continue or delete yours, and they're deleted with your account. Titles and histories are encrypted in the database.

To use the assistant, a person's role needs the **Use the AI Assistant** permission. See [Users and roles](/operations/users-and-roles).

## Your threads

- **Start a new one** with **New Chat**, at the top of the sidebar or the **+** at the top of the workspace. What you have on view is attached, ready for your first message.
- **Find an old one** with the history button at the top of the workspace. A new thread lists all of them by age, and at full size they have a column of their own.
- **Delete one** with **Delete Chat**, from the trash button on its row, its right-click menu or the three-dot menu at the top of the workspace, then confirm. It's gone for good. **Discard Draft** does the same for an unsent new one. Stop a running reply first.

The assistant names a thread after its first reply, and a thread is saved only once you send the first message, so empty ones never pile up. An unsent message stays with its thread while you move around the admin; reloading the page clears it, and brings back the thread you had open. Switching to another thread stops following the previous reply.

## Translate pages

With the assistant set up, [Languages](/content/languages) can translate pages too. Only the text is sent, and the translation opens as a draft.

## What it costs

The assistant uses your API key at Anthropic's prices. Lettern caches the parts of each request that don't change (instructions, tools, earlier messages), so long conversations stay affordable. The token usage of each thread is stored with it.

## For developers

### Environment variables

Instead of the admin setting, you can set `ANTHROPIC_API_KEY` in `.env`. To send requests through an API gateway or proxy, set `ANTHROPIC_BASE_URL` there: an `https://` address, or `http://` for localhost only. It can't be set from the admin, since every message would pass through it.

### Abilities and audit

The assistant runs [abilities](/agents/abilities) through the `assistant` transport, the same set MCP agents get. An ability can opt out with `expose: ['assistant' => false]`. Which changes need approval follows the ability's annotations: `destructive` and `confirm` (such as turning a plugin on or off) always ask, and so does any ability not exposed to MCP. See the annotations under [Abilities](/agents/abilities#for-developers).

### Interfaces in replies

Installed widgets are available in replies automatically. Plugins can add components described by a schema through the shared [generative UI SDK](/plugins/generative-ui), drawn by the same renderer as the admin's own places.

### Skills

Skills are registered with `cms()->skills()->register()`. The same skills are prompts for [MCP](/agents/mcp) clients.

### An agent like any other

The assistant is the workspace's [agent](/plugins/agents): it binds `Cms\Contracts\Agent`, keeps Claude's history with each thread, and streams its answers into the same turns commands and searches use. Another plugin can answer instead, with another model.

### Where it lives

The assistant is the `letterncms/assistant` module, in `modules/assistant` of Lettern, with its classes under `Cms\Modules\Assistant\`. It's on unless you switch it off under **Plugins → Built In**; switched off, nothing in the admin mentions AI, and its settings in `config/assistant.yaml` stay for when it's back.
