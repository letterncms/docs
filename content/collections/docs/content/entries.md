---
id: 01m5wmrf4x420a7rv1n4vxnper
title: Entries
position: 2
description: Write, save as you go, publish now or later, and go back to an earlier version whenever you need to.
---
An entry is one item in a collection: a page, a blog post, a survey. You fill it in, Lettern saves as you type, and nothing goes live until you publish.

![Filling in a survey: one simple form, with the fields the collection asks for.](/media/screens/entry.webp)

## Write and publish

1. Open a collection from the sidebar and press the **New** button, such as **New Survey**.
2. Give it a title and fill in the fields. Your work saves as you type.
3. Press **Publish** when it's ready. It's live straight away.

After that, your edits are kept apart from the live version. Visitors keep seeing what you published until you press **Publish Changes**.

| Status | Means |
|---|---|
| **Draft** | Saved, but not on the site yet. |
| **Published** | Live, and what visitors see. |
| **Changes** | Live, with edits that aren't published yet. |
| **Scheduled** | Goes live by itself at the time you chose. |
| **Expired** | Was live until its end date. It is off the site, and can be published again. |

On a live entry, **Published** in the top bar opens what publishing offers next: **Publication Date…** and **Unpublish**.

Changed your mind? Open **More Actions** (the `…` button) and choose **Discard Unpublished Changes** to go back to the live version, or **Unpublish** to take the entry off the site. Both ask first and say what you lose. In the collection's list, each row's **⋯** menu has **Publish** and **Unpublish** too.

| Press | To |
|---|---|
| `⌘S` | Save now |
| `⌘⇧P` | Publish |
| `⌘.` | Show or hide the entry details |

::: callout {"props":{"tone":"tip","text":"Drafts can be incomplete. Required fields only need to be filled in before you publish."}}
:::

Saving happens as you go. A small dot beside the title means a change is still on its way. If a save doesn't go through, a line over the page says why, like *Couldn't save. Check your connection.*, with **Try Again**. Your changes stay on screen, and Lettern asks before you leave the page.

## Preview it

Choose **More Actions → Preview** to see the entry as visitors will, at desktop, tablet or phone size, with the site's interactions working. It includes changes you haven't saved yet, and works even before the first save. Previewing never saves or publishes anything.

Once everything is published, the site shows exactly this version: the same place in the menu offers **View on Site** instead.

## Schedule it for later

Choose **More Actions → Schedule…**, pick a date and time, and press **Schedule**. The entry shows **Scheduled** and goes live by itself. Saving more edits doesn't change that time; use **Change Schedule** to move it. On a live entry, **Publication Date…** changes the date it was published.

## Give it an end date

Some pages should go offline by themselves: an offer, an event, a vacancy. The same dialog (**Schedule…** or **Publication Date…**) has **Starts** and **Ends**, both on the site's clock: its time zone is named under them. Set **Ends** and the entry leaves the site at that moment: it is gone from its page, from lists, from search and from the content API. **Remove End Date** takes the end away.

The entry's details say when it ends, or when it ended. An entry whose time is up reads **Expired**, in lists and in the editor, and can be published again from the editor, from its row or from a selection. In a list, the **Published** filter leaves expired entries out and **Expired** shows only those, and **Display** can add an **Ends** column.

An entry that's already live can't be scheduled for the future. Unpublish it first if you want to take it offline and bring it back later.

## Entry details

Press the panel button in the toolbar, named after the kind of entry (**Page Details**), or `⌘.`, to open the details on the right. The first tab is named after the kind of entry (**Page**, **Post**, **Survey**). **History** follows it, then any tabs plugins add, like **SEO**.

On the first tab you change the title, the URL slug and the **Author**. Fields set to **Show as Property** appear here too. Under **Info** you see its status and when it was published; people who can manage collections also see when it was created and updated. An entry's ID is **Copy ID** in **More Actions**.

The **Author** is the person credited for the entry, not necessarily the last person who edited it. It starts as whoever created the entry. You can change it or clear it; an entry nobody is credited for shows **Unassigned**. On a live entry, a new author waits for your next publish, like any other change.

## Go back to an earlier version

Every save is kept as a version. Several saves by the same person in a short time count as one.

Open the details and choose **History**: a timeline of what happened, who did it and when.

Click a version, tap it, or reach it with the keyboard, and it opens on exactly what restoring it would change. What is there now stands under **Current**, what the version brings back under **This Version**, field by field, and for a page block by block. A version that holds nothing different says *Same as now*.

Press **Restore Version** under it to bring it back. Its content comes back as unpublished changes, so you can check it before publishing. What you had before stays in the history.

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

### An end date

An entry can carry `expiresAt`: the moment it stops being published. Set it when publishing, with `expiresAt` on `entries/publish`, on `entries/create` with `status: "published"`, or on `entries/update` with `publish: true`. Publish a live entry again to move the date, and send `null` to remove it.

```bash
php cms run entries/publish id=01m75fmerrprznv7tkcgs8v0xk expiresAt=2026-12-31T23:00:00+01:00
```

From that moment the entry is no longer on the site, in lists, in the content API or in search, and its status reads `expired`. The scheduler (`cms publish:scheduled`, or the check after requests without cron) then unpublishes it: it is a draft again and its static page is removed. An entry that ran out can be published again at once; its past end date is dropped.

A date given with a time zone is kept as the moment it is: the one above comes back as `2026-12-31T22:00:00+00:00`. In a file collection it is `expires_at` in the front matter. `expires_at` filters and sorts like `published_at`. On `entries/list`, `status` takes `live` (published, its time has come and its end date has not), `expired` (published, and its end date has passed) and `active` (published and not expired: live or scheduled), beside `published`, `draft` and `any`.

### Reverse relations

`references/list` answers "what links to this entry?", across the collections you can view. An entry names another when its data has the other's id anywhere: in a relation or terms field at any depth (a group, the rows of a repeater or a matrix), in a link field, or in a link or relation inside a block. Each result carries `fields`, the fields that name it. Read it before deleting an entry others point at.

```bash
php cms run references/list id=01m75ewmnmrmh0d80z43axs3k5
```

```json
{
    "data": {
        "items": [
            { "id": "01m75fmerrprznv7tkcgs8v0xk", "collection": "events", "title": "Type night", "uri": "/events/type-night", "status": "published", "fields": ["host"], "…": "…" }
        ],
        "total": 1, "page": 1, "perPage": 25, "pages": 1
    }
}
```

The same question can be asked in other places:

- `entries/list` takes `references`, to narrow one collection's list to the entries that name an entry.
- The content API takes `?references=<id>`, and `references_field=` to look in one field only.
- The Repeat block's **Collection Entries** source has **Only Entries Linking To**, with **This Page** or **The Outer Item**: the posts of an author, the projects of a client. See [Showing content](/design/data).
- In PHP, `EntryQuery::references($id, $field = null)`, on database and file collections alike.

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

Everything on this page is available to the API, the command line and agents: `entries/create`, `entries/update`, `entries/publish`, `entries/unpublish`, `entries/discard-draft`, `entries/duplicate`, `entries/delete`, `entries/move`, `entries/reorder` and more, and an entry's history with `revisions/list`, `revisions/get` and `revisions/restore`. `references/list` finds what links to an entry. `collections/schema` gives the JSON Schema an entry's `data` must follow, and a field that fails is named by its path in the input, such as `data.summary`. See the [abilities reference](/reference/abilities#ns-entries).
