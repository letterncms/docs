---
id: 01m5wmrf4x420a7rv1n4vxnper
title: Entries
position: 2
description: Write, save as you go, publish now or later, and go back to an earlier version whenever you need to.
---
An entry is one item in a collection: a page, a blog post, a dish. You fill it in, Lettern saves as you type, and nothing goes live until you publish.

![Filling in a dish: one simple form, with the fields the collection asks for.](/media/screens/entry.webp)

## Write and publish

1. Open a collection from the sidebar and press the **New** button, such as **New Dish**.
2. Give it a title and fill in the fields. Your work saves as you type.
3. Press **Publish** when it's ready. It's live straight away.

After that, your edits are kept apart from the live version. Visitors keep seeing what you published until you press **Publish Changes**.

| Status | Means |
|---|---|
| **Draft** | Saved, but not on the site yet. |
| **Published** | Live, and what visitors see. |
| **Changes** | Live, with edits that aren't published yet. |
| **Scheduled** | Goes live by itself at the time you chose. |

Changed your mind? Open **More Actions** (the `…` button) and choose **Discard Unpublished Changes** to go back to the live version, or **Unpublish** to take the entry off the site. In the collection's list, each row's **⋯** menu has **Publish** and **Unpublish** too.

| Press | To |
|---|---|
| `⌘S` | Save now |
| `⌘⇧P` | Publish |
| `⌘.` | Show or hide the entry details |

::: callout {"props":{"tone":"tip","text":"Drafts can be incomplete. Required fields only need to be filled in before you publish."}}
:::

Saving happens as you go. A small dot beside the title means a change is still on its way. If a save doesn't go through, a line over the page says why, like *Couldn't save. Check your connection.*, with **Retry**. Your changes stay on screen, and Lettern asks before you leave the page.

## Preview it

Choose **More Actions → Preview** to see the entry as visitors will, at desktop, tablet or phone size, with the site's interactions working. It includes changes you haven't saved yet, and works even before the first save. Previewing never saves or publishes anything.

Once everything is published, the site shows exactly this version: the same place in the menu offers **View on Site** instead.

## Schedule it for later

Choose **More Actions → Schedule…**, pick a date and time, and press **Schedule**. The entry shows **Scheduled** and goes live by itself. Saving more edits doesn't change that time; use **Change Schedule** to move it. On a live entry, **Publication Date…** changes the date it was published.

An entry that's already live can't be scheduled for the future. Unpublish it first if you want to take it offline and bring it back later.

## Entry details

Press the panel button in the toolbar, named after the kind of entry (**Page Details**), or `⌘.`, to open the details on the right. The first tab is named after the kind of entry (**Page**, **Post**, **Dish**). **History** follows it, then any tabs plugins add, like **SEO**.

On the first tab you change the title, the URL slug and the **Author**. Fields set to **Show as Property** appear here too. Under **Info** you see its status and when it was published; people who can manage collections also see when it was created and updated, and its ID.

The **Author** is the person credited for the entry, not necessarily the last person who edited it. It starts as whoever created the entry. You can change it or clear it; an entry nobody is credited for shows **Unassigned**. On a live entry, a new author waits for your next publish, like any other change.

## Go back to an earlier version

Every save is kept as a version. Several saves by the same person in a short time count as one.

Open the details and choose **History**: a timeline of what happened, who did it and when. Point at the version you want and press **Restore**. Its content comes back as unpublished changes, so you can check it before publishing. What you had before stays in the history.

## Order and nest pages

In a collection with nested entries, like **Pages**, drag entries in the list to reorder them.

To put a page under another one, choose **More Actions → Move…**. Choose the new parent, or **Root** for the top level. Moving a page changes its address and those of the pages under it. Deleting a page moves its children up a level.

Moving doesn't publish anything: unpublished changes stay unpublished.

## Work together safely

When two people edit the same entry, Lettern never lets one save silently overwrite the other. If the entry changed since you opened it, Lettern asks whether to **Load Their Version** or **Keep Mine**.

With [collaboration](/editing/collaboration), you also see who else has the entry open, and can leave comments for each other.

## For developers

### Scheduling from the API

Set timing with `at` on `entries/publish`, or atomically with `status: "published"` on create or `publish: true` on update. `entries/create` and `entries/update` don't accept `publishedAt`; `at` only means something when publishing. Scheduling future updates to content that stays live is not supported.

Lettern publishes scheduled entries after web requests, at most once a minute. On a server with cron, run the check every minute instead:

```bash
* * * * * php /path/to/site/cms publish:scheduled
```

### Authors

`entries/create` and `entries/update` accept a nullable `authorId`. User pickers can look up safe person summaries with `people/list`. Imported or system-created entries can be unassigned, and an author reference that can't be resolved shows as **Unavailable person**. Lettern never invents authors or dates for imported content. History records separately who performed each action.

### Moving and ordering

`entries/move` changes a parent and `entries/reorder` orders siblings. They are structural commands, separate from saving content, and check the versions of the records they change.

### Conflicts

Pass the entry's opaque `version` as `expectedVersion` when changing an existing record. Read the latest version after each successful change; timestamps are display data, not conflict tokens. The admin always sends it. Leaving it out makes an unconditional write, so only do that when you mean to overwrite a concurrent change.

```json
{ "id": "01jc8w6m3x9k2h4v5t7r0p1q3s", "title": "New title", "expectedVersion": "<version returned by entries/get>" }
```

### Titles in templates

When a template shows the entry title through an exact `entry.title` text binding, editors can change the title right on the page; it's the same title as in the details. Sample titles shown while editing templates or components stay read-only.

### Abilities

Everything on this page is available to the API, the command line and agents: `entries/create`, `entries/update`, `entries/publish`, `entries/unpublish`, `entries/discard-draft`, `entries/duplicate`, `entries/delete`, `entries/move`, `entries/reorder` and more, and an entry's history with `revisions/list`, `revisions/get` and `revisions/restore`. `collections/schema` gives the JSON Schema an entry's `data` must follow, and a field that fails is named by its path in the input, such as `data.summary`. See the [abilities reference](/reference/abilities#ns-entries).
