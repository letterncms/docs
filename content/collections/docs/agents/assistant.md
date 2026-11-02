---
id: 01m5wn8r9bcb1yamdddxk5erm8
title: Assistant
position: 5
group: 'Agents'
description: Claude inside the admin. It builds, writes and fixes things with the same abilities you use, and asks before it deletes anything.
---
## Setting up

Add an Anthropic API key under **Settings → Assistant** (stored encrypted), or set `ANTHROPIC_API_KEY` in `.env`. To route requests through an API gateway or proxy, set `ANTHROPIC_BASE_URL` in `.env` (HTTPS only); it cannot be changed from the admin, since every chat would pass through it. Choose the default model for new chats — Claude Opus 5.5 unless you change it — and how much effort it may spend thinking. **Model for Small Tasks** names chats and suggests what to do next, so it runs often: Claude Haiku 5.5 unless you change it. Anyone can switch models from the picker under the chat box: the choice applies from the next message, stays with that chat, and becomes their starting model for new chats.

The assistant is optional: everything else in Lettern works without it. Until a key is set, **Chat** shows only to those who can add one, and opens the setup; nobody else sees an assistant they cannot use. If you don't use AI, **Hide Chat** on that screen takes it out of the top bar; `⌘J` still opens the setup, with **Show Chat** to bring it back.

## Using it

Click **Chat** in the top bar, on every screen, press `⌘J`, or type a request in the command palette (`⌘K`) and press `Enter`. It opens ready to type in.

The chat opens at the right edge of the window, on any screen, and the page stays open and usable beside it. Whatever you ask it to change shows there as it happens, in the builder too. Links in its replies open in the page next to the chat, so you can keep going. Drag its left edge to make it wider. `⌘J` from inside the chat, `Esc` or the close button puts it away; a reply keeps coming, and **Chat** in the top bar shows when it is working or waiting for your go-ahead.

**Full Size** grows the same chat over the whole window, with your chats beside it and a URL of its own to bookmark. The page you came from stays open underneath, and **Back to the Page** returns to it as you left it. Opening anything else from the sidebar does the same with that screen.

In an editor the chat floats over the page, at the right of the canvas, so the inspector stays where it is and the canvas doesn't move; drag it by its top bar to wherever suits you. Selecting a block with the chat open attaches that block, so "rewrite this" means it. Anywhere else, **Detach** does the same and **Dock Beside the Page** puts it back; your choice sticks. On a phone the chat fills the screen.

### What it can see

The chips in the composer show what your message will carry. Each comes off with its ×.

Without you doing anything, that's what you have on view:

- **The page on view**. In an editor that is the entry as it stands, saved first, so the assistant works on what you see. On any other screen it is the screen's text. Values in form fields are not part of it.
- **The block selected in the builder**, so "rewrite this" means that block.
- **Text you selected on the page**.

Type `@`, or click the **@** chip, to attach anything else: a page or post, a file from the library, a global set, the collections or the design system. Keep typing to narrow it down. For a file the assistant gets its details, not what the image shows. Something that hasn't changed since your last message isn't sent again.

Type `/` at the start of a line for a skill, a ready-made way of working: `/proofread` this page, `/build-page`, `/write-post`, `/audit-site`, `/adjust-design`. Write the details in your message, or send the skill alone when it needs none.

**Account**, **Users**, **Licence** and **Audit Log** stay private: they show no chip, and the assistant gets only the address of the screen. Each message you send shows what it carried, and clicking it takes you there.

### Your chats

Your chats are in one place, in the chat: a new chat lists all of them by age, the history button at the top of a chat takes you there, and at full size they have a column of their own. To permanently remove a chat, choose **Delete Chat** from the trash button on its row, its right-click menu or the three-dot menu at the top of the chat, then confirm; **Discard Draft** does the same for an unsent new chat. Stop any running reply first.

The **+** at the top of the chat starts a fresh conversation; an unsent one waits there. It suggests what to work on, based on what you have on view; a suggestion goes into the composer for you to read and send. A chat names itself after the first reply. Empty chats are never saved: a conversation is created only when you send the first message. Drafts stay attached to their chat while you move around the admin in the same browser session; reloading clears unsent drafts, and brings back the chat you had open. Selecting another conversation stops listening to the previous reply.

You see what it does as it works: its reasoning summary, every tool call with its input and result, and its answer. Changes appear in the admin immediately.

For overviews, comparisons and next-step choices, replies can include a contextual interface: live plugin widgets, metrics, trends, tables and actions composed for your request. These use the same components as the rest of the admin and remain available when you reopen the chat. Choosing a generated action follows the same permission, approval and audit rules as any other assistant action.

Installed widgets become available automatically. Plugins can also contribute schema-described components through the shared [generative UI SDK](/plugins/generative-ui), powered by json-render.

## Safety

- It acts **as you**: same permissions, same audit log (marked *assistant*).
- It never sees security abilities — tokens, passwords, users and roles.
- **Deleting** anything, and admin-level changes, wait for your approval in the chat. Under **Settings → Assistant** you can require approval for every change instead.
- Site content, form submissions, comments and anything else it reads are treated as data, never as instructions. That goes for the page on view too. Once a chat has read such content, it can still save drafts on its own: nothing there is live until it's published, and the history keeps what was there. Anything else it wants to do waits for your approval, including publishing, so text planted by someone else cannot reach your visitors or do anything you can't undo.
- Chats are private to you: nobody else can list, open, continue or delete them, and they are deleted with your account. Titles and histories are encrypted in the database.

## Translation

With the assistant set up, the [languages plugin](/content/languages) can translate pages: only the text is sent, and the result opens as a draft.

## Costs

The assistant uses your API key and Anthropic's pricing. Lettern caches the stable part of every request (instructions, tools, earlier messages), so long conversations stay affordable. Token usage is stored with each conversation.
