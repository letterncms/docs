---
id: 01m75g1ygdx5r97a6sq8az2dwx
title: Import
position: 12
description: 'Bring a site over from WordPress, a CSV file or a folder of Markdown. Preview first, and run it again without making copies.'
---
The Import plugin brings content from somewhere else into your site: a WordPress export, a CSV file, or a folder of Markdown files. Every import is previewed first. And it can be run again: what it made before is updated when its source changed, left alone when it did not, and never made twice.

It is free: install it from **Plugins**, or with `composer require letterncms/import`. Importing is done in the admin, from the command line or by an agent; it needs the **Import Content** permission, which administrators have.

## In the admin

Open **Settings → Import**.

1. **Upload File** takes a WordPress export (`.xml`, up to 20 MB), a CSV file (up to 50 MB) or a zip of Markdown files, which is unpacked into a folder. Files already in `storage/app/import/` are listed too.
2. The file opens on its **Preview**: how many entries would be created, updated or left unchanged, and each one as the entry it becomes. An entry marked as replacing one is a record with the same slug as an entry that is already on the site and that no import made: importing it changes that entry. **Media** lists the files it would fetch and **Redirects** the old addresses it would redirect. Nothing has been written yet.
3. **Options** says where the entries go. For a CSV it also says what each column is: the title, the slug, the status, the publish date, the body, an old address to redirect, one of the collection's fields, or left out. Save, and the preview follows.
4. **Start Import** runs it and shows how far it is; it is there only when the preview has something to change. It works a few seconds at a time, so you can reload or close the page without losing anything: on PHP-FPM and LiteSpeed it carries on by itself, elsewhere it carries on when you open it again. A file that cannot be fetched is tried once per import and reported. **Cancel Import** stops it; what it made stays, and starting the file again picks up from there.
5. **History** keeps the report of every import: what was created, updated, left unchanged or failed, with the way to each entry.

## On the command line

1. Put the file or folder in `storage/app/import/` on your site.
2. Look at what it would do, with `--dry-run`.
3. Run it.

```bash
php cms import markdown notes --collection=posts --dry-run
```

```
  create  posts      Hello there
  create  posts      Second (draft)
  add     redirect   /old/hello → (its new address)
Dry run: 2 to create, 0 to update, 0 unchanged, 0 files to fetch, 1 redirects to add (reported only: SEO is off).
```

Then the same command without `--dry-run`.

A record that can't be published yet, because a required field is empty, comes in as a draft, and the report says why.

## From WordPress

Export everything in WordPress under **Tools → Export**, then:

```bash
php cms import wordpress export.xml --dry-run
php cms import wordpress export.xml
```

- Posts go to `posts` and pages to `pages`, unless `--collection` and `--pages` say otherwise. `--type-map=product=products` brings another post type along.
- Text becomes Markdown, blocks or rich text, whichever the collection's body field is.
- Images in the text and featured images are fetched into the media library, in the folder `import`. A file the old site did not hand over is reported; the next run fetches it and puts it into the entries that show it.
- With [SEO](/operations/seo-and-geo) on, each old permalink redirects to the entry's new address.

## From a CSV file

One row is one entry, and the first row names the columns.

```bash
php cms import csv products.csv --collection=products --map=Name=title --map=Price=price
```

A column goes to the field of the same name. `title`, `slug`, `status`, `date`, `body` and `redirect_from` are the entry's own. `--map=Column=field` sends a column elsewhere, and `--key` names the column that tells rows apart (`id` when there is one).

## From Markdown

Every `.md` file in the folder, with YAML front matter:

```bash
php cms import markdown notes --collection=notes
```

`title`, `slug`, `date`, `draft` and `redirect_from` or `aliases` are the entry's own; other keys go to the field of the same name. A file named `2024-05-01-hello.md` is `hello`, published that day.

## For developers

### Options

`--as=you@example.com` makes the entries that person's, and `--json` prints the report as [one JSON document](/agents/cli#json-from-every-command).

### Abilities

| Ability | Does |
|---|---|
| `import/sources` | Lists what is in `storage/app/import/`, with the type each looks like |
| `import/preview` | Says what an import would do, per record, file and redirect, without doing it |
| `import/run` | Runs the import in one go and answers with the same report. With `dryRun: true` it writes nothing and lists the entries, files and redirects it would make |
| `import-sources/get` | One source with what was chosen for it (`options`), and the columns of a CSV |
| `import-sources/update` | Chooses where a source's entries go and what each CSV column is |
| `import-sources/preview` | What importing a source would do with what was chosen for it, a page at a time: `of` is `entries`, `media` or `redirects` |
| `import-sources/delete` | Removes a file or folder from the import folder, not while it is being imported. A dry run says how many files go |
| `import-runs/start` | Starts importing a source a few seconds at a time. A dry run lists what it would make |
| `import-runs/step` | Imports for a few seconds more and says how the import stands: call it until `status` is no longer `running`. What failed in an earlier turn is not tried again, and the Audit Log keeps only the turn that finishes |
| `import-runs/cancel` | Stops an import that is running |
| `import-runs/list` | The imports that were started, newest first, a page at a time |
| `import-runs/get` | One import: how far it is, and a page of what it did |
| `import-runs/delete` | Forgets a finished import's report |

All of them need `import.run`. Through an ability or the admin a WordPress export may be 20 MB; the command line reads up to 256 MB. The admin uploads a file with `POST /api/admin/import/upload` (multipart, field `file`).

```bash
php cms run import/sources
```

```json
{
    "data": {
        "folder": "storage/app/import",
        "sources": [
            { "id": "bm90ZXM", "path": "notes", "type": "markdown", "size": null }
        ]
    }
}
```

### Hooks

Entries are saved through the entry service and files through the media library, so `entry.saved`, `entry.published` and `media.uploaded` fire as they do for any other change, and redirects go through SEO's `redirects.saved`. The plugin adds no hooks of its own.
