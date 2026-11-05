---
id: 01m6bfgzctedfs408fz2e5javb
title: Moving a site with Sync
position: 9
description: Copy content between your machine, staging and production in one click, with a preview first and an undo after.
---
Sync copies one site into another: its content, its media, and if you like its templates and settings. Pull the live site onto your laptop to work with real content, push a finished section from staging to production, or refresh staging before showing the client. You see what will change first, and can undo it afterward.

![Sync, with production and staging connected.](/media/screens/operations-sync.webp)

Sync comes with Lettern and is free on every site, public ones included: there's nothing to install or buy. It's on unless you switch it off under **Plugins → Built In**.

## Connect two sites

1. On the first site, open **Sync** and copy **This Site’s Key**. It starts with the site's address.
2. On the second site, open **Sync** and press **Connect a Site**.
3. Paste the key, give the site a name like *Production*, and press **Connect**.

That's all: no SSH, no database password, nothing to open in a firewall. Only the site you connect from has to be able to reach the other one. **Disconnect**, beside a connected site's name, removes it again.

::: callout {"props":{"tone":"warning","text":"Anyone with a site's key can read and replace its content. Keep it like a password. <strong>Make a New Key</strong> replaces it, and sites connected with the old one then need the new one."}}
:::

Each site can also switch off **Allow Pull From Other Sites** or **Allow Push From Other Sites**, and save from the bar at the bottom.

## Pull or push

- **Pull** copies the other site into this one.
- **Push** copies this one into the other.

Press **Pull** or **Push** next to a connected site. Sync compares the two and shows you what changes, group by group. Tick what should move, then press **Pull Now** or **Push Now**.

| Group | What moves | Pushed by default | Pulled by default |
|---|---|---|---|
| Content | Entries and their history. You can choose collections. | Yes | Yes |
| Media | Uploaded files and their details | Yes | Yes |
| People | Accounts, roles and access | No | Yes |
| Comments | Comments and mentions in the admin | No | Yes |
| Chats | Each person's threads in the workspace, with the assistant's answers | No | Yes |
| Logs | Sent email and the audit log | No | Yes |
| Each plugin's data | One group per plugin, such as Form Submissions, Analytics, and Commerce's products, orders, invoices and licenses | No | Yes |
| Site Files | Templates, components, collections kept in files, globals, forms, menus | No | No |
| Settings | Settings, except which plugins are on and the license key | No | No |
| Other tables | Tables in the same database that no plugin claims | No | No |

Pushing is for what your team makes, so what visitors leave behind on a live site, like orders and form submissions, stays there unless you tick it. Pulling brings everything, the way you want production on your machine. Site files and settings usually travel by git; tick them when they don't.

Addresses are rewritten on the way: a page that links to `https://www.example.com` links to `http://localhost:8000` once it's on your machine. Media only moves what differs, so the second push of a big library takes seconds.

## What each site keeps

Whatever moves, the receiving site keeps:

- its passwords and API keys, its license key and which plugins are on;
- its Sync key and connections;
- Commerce's mode and keys: a pulled shop stays in test mode on your machine, and a pushed one keeps selling live;
- everyone who is signed in.

## Undo a sync

Before Sync replaces anything, it makes a backup. **History** lists what came into this site, such as *Pulled from Staging* or *Staging pushed to this site*, and **Undo** puts back what was there before. To undo a push, press **Undo Last Push** under the other site, on the site you pushed from.

Undo also replaces whatever changed since the sync. The last three backups are kept.

## Big sites and slow hosts

Sync works a few seconds at a time, so no request comes near a host's time limit, and the admin shows how far it is and how long is left. If the connection drops or you close the tab, it carries on from where it was when you come back.

## When Sync says no

Sync checks before it starts, and tells you what to do:

- **Different versions.** If a group's tables differ between the two sites, that group can't move until both run the same versions of Lettern and of the plugin the tables belong to. Other groups still can.
- **A plugin on one side only.** Its data stays where it is, and the preview says so.
- **The same site twice.** A site can't sync with its own key, with a copy of its own folder, or with a site sharing its database.
- **Busy.** One sync at a time per site. A second waits until the first ends.
- **Permissions and disk space.** The receiving site needs to write to the folders that change, and room for the incoming copy and the backup.
- **No answer.** If the other site doesn't answer as a site with Sync, check its address, and that Sync is on there under **Plugins → Built In**.

Different databases (MySQL and SQLite) or table prefixes are fine: rows are converted on the way.

## For developers

### From the command line

```bash
php cms remote key                         # this site's key
php cms remote add production '<key>'      # connect the other site
php cms remote                             # the connected sites

php cms pull production                    # the usual set, after a preview and a question
php cms push staging content media         # just these
php cms pull production content --collections=posts,pages
php cms push production --dry-run          # the preview, and stop
php cms pull production --yes --replace='cdn.example.com=>localhost:8000/cdn'
php cms sync:undo --remote=staging         # undo the last push to staging
```

When a site's own address doesn't work from where you connect, such as two containers on one Docker network, turn on **This Server Reaches It at Another Address**, or add `--url=http://web:8000` to `remote add`. For a copy of a site's folder, run `php cms remote key --new` on the copy to give it a key of its own.

### What moves, exactly

Media is `public/media` and its details in `content/media`, compared by size and time. Site Files is `content/`. Settings is `config/`. Folder paths are rewritten along with addresses.

The receiving site also keeps its `.env`, its secrets (from **Settings**, kept in `storage/`), its sessions, API and sign-in tokens, its queue and caches, and Commerce's outbox. When people are replaced, each session follows its person to their account with the same email, and someone who has no account on the other site keeps theirs.

For a group with different tables, run `php cms sync` on each site after updating, so both have the same columns.

### How it switches over

Nothing on the receiving site changes until everything has arrived. Rows wait in staging tables and files in a staging folder while the site runs as before. Then Sync backs up what is about to be replaced and switches over: all tables in one transaction, then the files. Backups are in `storage/sync/backups`.

Tables go in chunks in key order, and big files in pieces of 2 MB or half the host's `post_max_size`, whichever is smaller. If a request times out, the sync carries on from the last piece when you come back or run the same command again. The receiving site keeps its staged copy for ten minutes; after that it starts afresh. A second sync waits for the first, or for ten minutes if it stopped halfway.

### Security

Every request between two sites is signed with the key's secret, with its time and a one-time value, so a captured request can't be sent again and nobody without the key gets an answer. Paths that leave their folder, hidden files and links are refused on both sides. Syncing is kept away from the assistant and MCP: replacing a site is a person's decision. The permission **Push and Pull Content Between Sites** decides who sees **Sync**.

### Where it lives

Sync is the `letterncms/sync` module, in `modules/sync` of Lettern, with its classes under `Cms\Modules\Sync\`. Switched off, a site has no **Sync** screen and none of the commands above, and doesn't answer other sites. Its key, connections and history are in `storage/sync`.

### Plugins with their own tables

A plugin's tables are grouped as its `composer.json` says: see [Sync for plugins](/plugins/sync).
