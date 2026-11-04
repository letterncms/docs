---
id: 01m5wn8r9fm7mdbms8ycav18sz
title: Collaboration
position: 4
description: See who else is on a page, talk it through in comments, and never lose work to someone else's save.
---
When you build a site with a client or a team, Lettern shows who else has a page open, lets you discuss it in comments right next to it, and makes sure nobody's save quietly wipes out someone else's work.

![A comment thread on the home page: a question from the studio and the client's answer.](/media/screens/editing-comments.webp)

## See who's here

Open a page and the toolbar at the top shows everyone else who has it open. A ring marks the people who are typing. Point at the faces to see who is editing and who is just viewing.

If someone saves while you have the page open, a button appears: **Marta saved · Reload**. Press it to load their version. Any edits you haven't saved yet are replaced.

## Comment on a page

1. Open the page, then the **Comments** tab in the sidebar on the right. Press `⌘.` if the sidebar is closed.
2. Write your comment in **Add a comment…** and press the arrow beside it, or `⌘↵`.
3. To bring someone in, type `@` and pick their name. They get an email with a link to the page.

Everyone can **Reply** under a thread, and everyone already in it gets an email. When it's settled, press the check mark to **Resolve** it. Resolved threads fold away at the bottom, and a new reply reopens them.

To edit or delete your own comment, use the **⋯** next to it. Deleting a comment deletes its replies too.

::: callout {"props":{"tone":"tip","text":"Keep an eye on everything waiting for you: on the Dashboard, press <strong>Customize</strong>, then <strong>Add Widget</strong> and add <strong>Comments</strong>. It lists open threads that mention you or sit on pages you created."}}
:::

The assistant can take part too. Ask it to *"go through the open comments on this page"*.

## When two people edit at once

If two people change the same page, the later save never silently overwrites the earlier one. Instead, a bar says who changed it, and saving pauses until you choose:

- **Load Their Version** takes their changes and drops yours.
- **Keep Mine** saves your version over theirs, on purpose.

Until you choose, Lettern warns you before you leave the page, so your edits aren't lost by accident. Publishing and moving pages are protected the same way. See [Entries](/content/entries).

## For developers

### Permissions

| Permission | Allows |
|---|---|
| `comments.view`, **View Comments** | Reading comments |
| `comments.create`, **Write and Resolve Comments** | Commenting, replying, resolving, editing and deleting your own comments |
| `comments.moderate`, **Edit and Delete Anyone’s Comments** | Editing and deleting anyone's comments |

### Abilities

Comments are abilities, for the assistant, MCP and the API: `comments/list`, `comments/create`, `comments/update`, `comments/resolve`, `comments/delete`, `comments/people` and `comments/inbox`. Presence uses `collaboration/presence`.

### How presence works

Each open editor sends a short heartbeat every 15 seconds, kept in the cache. It needs no websockets, so it runs on shared hosting. A hidden browser tab stops sending until it's visible again.

### Version checks

Every save, publish and move sends the version it started from. If the entry has changed since, the request fails with a `conflict` instead of overwriting it.
