---
id: 01m6zm05rnzjmm2wt1gqrqksfw
title: Sync for plugins
position: 9
description: Tell Sync which of your plugin's tables are content, which are what visitors leave behind, and which never leave a site.
---
[Sync](/operations/sync) copies one site into another, such as the live site onto your laptop. If your plugin keeps its own database tables, you can tell Sync how to treat them. Usually you don't have to do anything at all.

## What happens by default

Sync moves tables by name, without the prefix, and groups them the way people choose. Your plugin's tables named after it, like `bookings_*` for `acme/bookings`, form one group under the plugin's label: ticked when pulling, and not when pushing.

## Say more

Add `sync` to `extra.cms` in your plugin's `composer.json`. No code, and nothing to depend on:

```json
"extra": { "cms": { "sync": {
  "keep": ["bookings_tokens", "bookings_queue"],
  "groups": {
    "bookings": {
      "label": "Bookings",
      "description": "Appointments and the people who made them.",
      "tables": ["bookings_*"],
      "push": false,
      "pull": true
    }
  }
} } }
```

| Key | Meaning |
|---|---|
| `keep` | Tables that never leave a site: tokens, queues, keys, anything that only makes sense where it was made. A name, or a prefix ending in `*`. |
| `groups.<id>.label`, `description` | How the group is shown when someone pushes or pulls. |
| `groups.<id>.tables` | The tables that make up a group. A table belongs to the first group that names it. |
| `groups.<id>.push`, `pull` | Whether the group is ticked by default when pushing and when pulling. Push what a team makes; leave what visitors leave behind unticked. |

## What your plugin can count on

- **Whole tables.** A table is replaced as a whole, or, for entries and revisions, by collection.
- **Your schema.** Rows arrive with your schema on the receiving side. Columns it doesn't have are refused before anything moves; columns it has and the rows don't get their defaults.
- **Addresses.** Addresses and folder paths in every text column are rewritten, inside JSON and PHP-serialized values too. Keep absolute URLs out of your data where you can; when you can't, they still come out right.
- **Files.** Files your plugin keeps under `content/` move with **Site Files**, and settings in `config/` with **Settings**. `storage/` never moves: keep there what belongs to one site.
- **A fresh start.** After a switch, the `cms.sync` hook runs, as after `php cms sync`, the cache is flushed and the site queues a full build. Rebuild any index of your own there.

## The protocol

Two sites talk over `POST /api/sync/v1/<op>` with a gzipped body. Each request carries `X-Sync-Time`, `X-Sync-Nonce` and `X-Sync-Signature`: an HMAC-SHA256 with the key's secret over `cms-sync-1`, the operation, the time, the nonce and the SHA-256 of the body, joined by newlines.

Requests older than five minutes, or seen before, are refused. Reads need pulls allowed on that site, writes need pushes allowed, and a public site answers only `hello` without a licence.
