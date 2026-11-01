---
id: 01m5wn8r9fm7mdbms8ycav18sz
title: Collaboration
position: 4
group: 'In the editor'
description: See who else is on a page, discuss it in comment threads, and never lose work to a simultaneous edit.
---
## Presence

Open an entry and the toolbar shows everyone else who has it open, with a ring around people who are typing. If someone saves while you are reading, a **Reload** button appears. Presence works over short heartbeats, so it needs no websockets and runs on shared hosting.

## Comments

Open the **Comments** tab in an entry's side panel. Start a thread, reply, and mention people with `@` — mentioned people get an email with a link to the entry. Replies notify everyone already in the thread. **Resolve** a thread when it is done; a new reply reopens it.

The **Comments** widget lists open threads that mention you or sit on entries you created — add it to your home screen with **Customize → Add widget**.

| Permission | Allows |
|---|---|
| `comments.view` | Reading comments |
| `comments.create` | Commenting, replying, resolving, editing and deleting your own comments |
| `comments.moderate` | Editing and deleting anyone's comments |

Agents can take part too: `comments/list`, `comments/create` and `comments/resolve` are abilities — ask the assistant to "go through the open comments on this page".

## Edit conflicts

If two people change the same entry, the later save does not silently overwrite the earlier one. Lettern shows who changed it, pauses autosave, and lets you load their version or explicitly keep yours. Your local edits remain protected from accidental navigation while the conflict is unresolved. Publication and structural commands use the same version checks, so a stale publish or tree move cannot silently overwrite a newer record. See [Entries](/content/entries#working-together).
