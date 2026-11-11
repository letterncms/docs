---
id: 01m75g1ygdx5r97a6sq8az2dwx
title: Import
position: 12
description: 'Bring a site over from WordPress, a CSV file or a folder of Markdown. Preview first, and run it again without making copies.'
---
The Import plugin brings content from somewhere else into your site: a WordPress export, a CSV file, or a folder of Markdown files. Every import is previewed first. And it can be run again: what it made before is updated when its source changed, left alone when it did not, and never made twice.

It is free: install it from **Plugins → Store**, or with `composer require letterncms/import`. Importing is done from the command line or by an agent; it needs the **Import Content** permission, which administrators have.

## How it goes

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
| `import/run` | Runs the import and answers with the same report. With `dryRun: true` it writes nothing and lists the entries, files and redirects it would make |

All three need `import.run`. Through an ability a WordPress export may be 20 MB; the command line reads up to 256 MB.

```bash
php cms run import/sources
```

```json
{
    "data": {
        "folder": "storage/app/import",
        "sources": [
            { "path": "notes", "type": "markdown", "size": null }
        ]
    }
}
```

### Hooks

Entries are saved through the entry service and files through the media library, so `entry.saved`, `entry.published` and `media.uploaded` fire as they do for any other change, and redirects go through SEO's `redirects.saved`. The plugin adds no hooks of its own.
