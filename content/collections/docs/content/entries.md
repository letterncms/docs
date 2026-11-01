---
id: 01m5wmrf4x420a7rv1n4vxnper
title: Entries
position: 4
group: 'Manage'
description: Write, save drafts, publish now or later, roll back — and never overwrite a colleague's work.
---
## Draft, published, changed

A new entry is a **draft**: saved, previewable, not on the site. **Publishing** puts it live. After that, edits collect in a working copy — the entry shows **Changes** — while visitors keep seeing the published version until you publish again or **discard** the changes.

The editor saves as you type. Press `⌘S` to save now and `⌘⇧P` to publish. Drafts can be incomplete; required fields must be filled before publishing. A failed save keeps your changes in the editor, shows an error with a retry, and warns before you leave. Autosave pauses on an edit conflict until you choose which version to keep.

Use **Preview** in the entry toolbar to check the current working title, content, URL and author with the site's interactions enabled. Preview includes unsaved changes and works before the first save; it does not publish or save the entry.

## Entry details

The right sidebar starts with a tab named after the collection's entry type: **Page**, **Post**, **Template**, and so on. **History** follows it, then any plugin panels. Every collection uses these same entry details and panel definitions.

Use the first tab to edit the title, author and URL slug or non-page handle, and review publication state and record dates. For collections with a blocks body, the main body is edited directly in the live rendered surface and other collection fields appear in Details. Fields owned by an active plugin appear in that plugin's panel; when it is unavailable, the fields remain accessible in the entry details.

When a template renders the entry title through an exact `entry.title` text binding, you can edit it inline too. It changes the same title as Details. Sample titles shown while editing templates or components remain read-only.

The **Author** is the person credited for the content, not necessarily the last person who edited it. New entries default to their creator when there is one; imported or system-created entries can be **Unassigned**. An author reference that cannot be resolved appears as **Unavailable person**. You can change or clear the author. For a published entry, an author change stays in its working copy until you publish; discarding changes restores the published author. History separately records who performed each action. Lettern does not invent authors or dates for imported content.

## Scheduling

Use the publishing controls to schedule an unpublished entry or change an existing schedule. The entry shows **Scheduled** and goes live at the selected time. Saving content or author changes does not change the publication time. A live entry cannot be moved to a future publication time: unpublish it first if you want to take it offline and schedule it again.

API clients set timing with `at` on `entries/publish`, or atomically with `status: "published"` on create or `publish: true` on update. `entries/create` and `entries/update` do not accept `publishedAt`; `at` is only meaningful when publishing. Scheduling future updates to content that remains live is not supported.

Lettern catches up after web requests at most once a minute; on a server with cron, run the check every minute instead:

```bash
* * * * * php /path/to/site/cms publish:scheduled
```

## Revisions

Each save records a revision (several saves by the same person in a short time count as one). **History** lists them; restoring one puts its content back as a draft, so you can review before publishing.

## Trees

In tree collections, reorder siblings in the list. To change a parent, open the entry's details tab and choose **Move** under **Record**. Select an eligible parent or **Root** for the top level; the entry and its descendants cannot be their own parent. Moving a page updates its URL and every descendant's. Deleting a page moves its children up a level. Structure changes do not publish a working content draft.

API clients use `entries/move` to change a parent and `entries/reorder` to order siblings. These are explicit structural commands, separate from saving content, and check the versions of the records they change.

## Working together

When two people edit the same entry, the second save would overwrite the first — so it doesn't. Lettern notices the entry changed since you opened it and asks whether to load the other version or keep yours. With the [collaboration plugin](/editing/collaboration) you also see who else has the entry open before it comes to that.

API clients get the same protection by passing the entry's opaque `version` as `expectedVersion` when changing an existing record. Read the latest version after each successful mutation; timestamps are display metadata, not conflict tokens. The admin always supplies the version. Omitting it in an API call explicitly makes an unconditional write, so only do that when overwriting a concurrent change is intended.

```json
{ "id": "01jc8w6m3x9k2h4v5t7r0p1q3s", "title": "New title", "expectedVersion": "<version returned by entries/get>" }
```

## Abilities

Everything above is available to the API, the CLI and agents: `entries/create`, `entries/update`, `entries/publish`, `entries/unpublish`, `entries/discard-draft`, `entries/duplicate`, `entries/delete`, `entries/move`, `entries/reorder`, `entries/revisions`, `entries/restore` and more — see the [abilities reference](/agents/abilities-reference#ns-entries). Create and update accept a nullable `authorId`; user pickers can resolve safe person summaries with `users/lookup`.
