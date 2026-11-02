---
id: 01m6bfgzctedfs408fz2e5javb
title: Moving a site with Sync
position: 7
description: Push or pull a site between your machine, staging and production in one click or one command, with a preview first, a backup and undo.
---
Sync is a paid plugin from the store. It copies one site into another: the database, all of it or the parts you choose, the media, and if you like the files in `content/` and `config/`. Addresses and folder paths are rewritten on the way, so a page that links to `https://www.example.com` links to `http://localhost:8000` once it's on your machine.

It works between any two sites that have it, whichever way round: pull production onto your laptop to work on real content, push a finished section from staging to production, refresh staging from production before a release.

Sync is free between local and staging sites. A public site takes part with a Sync licence, which it checks itself.

## Connect two sites

Each site has a connection key under **Sync**, made of its address and a secret: `https://www.example.com#…`. On the other site, choose **Connect a Site**, paste the key and give it a name, like Production. That's all: no SSH, no database password, nothing to open in a firewall. The site you connect from does the work, so only it has to reach the other one.

From a terminal:

```bash
php cms remote key                         # this site's key
php cms remote add production '<key>'      # connect the other site
php cms remote                             # the connected sites
```

Anyone with a site's key can read and replace that site's content, so keep it like a password. **Make a New Key** replaces it; sites connected with the old one then need the new one. Each site can turn off pulls from it, pushes to it, or both.

When a site's own address doesn't work from where you connect, such as two containers on one Docker network, tick **This server reaches it at another address**, or add `--url=http://web:8000` to `remote add`.

## Pull and push

**Pull** copies the other site into this one. **Push** copies this one into the other. Either way you see what changes first, per group:

| Group | What moves | Pushed by default | Pulled by default |
|---|---|---|---|
| Content | Entries in the database and their history. You can choose collections. | Yes | Yes |
| Media | Uploaded files in `public/media` and their details in `content/media` | Yes | Yes |
| People | Accounts, roles and access | No | Yes |
| Each plugin's data | Form submissions, Commerce's orders and invoices, comments, analytics, assistant chats, logs | No | Yes |
| Site Files | `content/`: templates, components, collections kept in files, globals, forms, menus | No | No |
| Settings | `config/`, except which plugins are on and the licence key | No | No |
| Other tables | Tables in the same database that no plugin claims | No | No |

Pushing is for what a team makes, so what visitors leave behind on a live site stays there unless you tick it. Pulling brings everything, the way you want production on your machine. Site files and settings usually travel by git; tick them when they don't.

```bash
php cms pull production                    # the usual set, after a preview and a question
php cms push staging content media         # just these
php cms pull production content --collections=posts,pages
php cms push production --dry-run          # the preview, and stop
php cms pull production --yes --replace='cdn.example.com=>localhost:8000/cdn'
```

Media is compared by size and time, and only what differs moves: the second push of a big library takes seconds.

## What stays

The receiving site keeps, whatever moves:

- its `.env`, its secrets (passwords and API keys from **Settings**, kept in `storage/`), its licence key and which plugins are on;
- its Sync key and connections, its sessions, API and sign-in tokens, its queue and caches;
- Commerce's mode, keys and outbox: a pulled shop stays in test mode on your machine, and a pushed one keeps selling live;
- everyone who is signed in. When people are replaced, each session follows its person to their account with the same email, and someone who has no account on the other site keeps theirs.

## Backup and undo

Nothing on the receiving site changes until everything has arrived. Rows wait in staging tables and files in a staging folder while the site runs as before. Then Sync makes a backup of what is about to be replaced and switches over: all tables in one transaction, then the files.

**Came In Lately** lists what came into a site, and **Undo** puts back what was there before, from that backup. A push can be undone from the site you pushed from, under the other site's menu, or with `php cms sync:undo --remote=staging`. The last three backups are kept, in `storage/sync/backups`. Undo also replaces whatever changed since the sync.

## Big sites and slow hosts

Sync works a few seconds at a time, so no request comes near a host's 30 or 60 second limit, and the admin shows how far it is. Tables go in chunks in key order, big files in pieces of 2 MB or half the host's `post_max_size`, whichever is smaller. If a request times out, the connection drops or the tab closes, the sync waits and carries on from the last piece when you come back, or when you run the same command again. The receiving site keeps its staged copy for ten minutes; after that it starts afresh.

## When Sync says no

Sync checks before it starts and tells you what to do:

- **Different versions.** Both sites need the same tables. If one has a column the other lacks, that group can't move until both run the same versions of Lettern and the plugin, with `php cms sync` run on each. Other groups still can.
- **A plugin on one side only.** Its data stays where it is, and the preview says so.
- **MySQL and SQLite**, or different table prefixes: fine, rows are converted on the way.
- **The same site twice.** A key that belongs to this site, a copy of its folder (run `php cms remote key --new` on the copy) or two sites sharing one database are refused.
- **Busy.** One sync at a time per site. A second waits until the first ends, or for ten minutes if it stopped halfway.
- **Permissions and disk space.** The receiving site needs to write to the folders that change, and room for the incoming copy and the backup.
- **No licence.** A public site without a Sync licence takes no part. Add the key under **Licence** on that site.

## Security

Every request between two sites is signed with the key's secret, with its time and a one-time value, so a captured request can't be sent again and nobody without the key gets an answer. Paths that leave their folder, hidden files and links are refused on both sides. Syncing is kept away from the assistant and MCP: replacing a site is a person's decision. The permission **Push and pull this site's content** decides who sees **Sync**.

For plugins that keep tables of their own, see [Sync for plugins](/plugins/sync).
