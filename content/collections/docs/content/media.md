---
id: 01m5wmrf5dhes3ka6256cnzk25
title: Media
position: 5
group: 'Manage'
description: Upload once; Lettern serves every image in the right size and format, with alt text and focal points.
---
## Uploading

Use **Upload** on the **Media** screen, paste them into the editor, or import from a URL. Every upload is checked: the real file type is detected from its contents (not its name), SVGs are cleaned of scripts, photo metadata such as GPS positions is removed, and duplicates are recognized. Organize files in folders and give each image **alt text** — the SEO checks will remind you.

## Responsive images

Lettern creates WebP and AVIF versions in several widths the first time they are requested and keeps them in `public/_cms/img/`, so static pages load them without PHP. Set a **focal point** and crops keep the important part in frame.

The **Image** block renders a complete `<picture>` element. Its **Sizes** setting tells the browser how wide the image is shown, and **Load first** marks it as important for the first screen (no lazy loading, high fetch priority). Width and height are always set, so the layout never jumps.

Images also work as backgrounds: pick one under **Design → Fill → Image** (stored as `media:<id>`), or bind `style:backgroundImage` to an image field. To show a field's image, bind the Image block's image to it: `"bind": { "image": "entry.hero" }`.

In PHP, a media field's value renders itself (`(string) $entry->hero`), and offers `img(['sizes' => …, 'priority' => true])` and `src(1200, 'jpg')`.

## For agents

`media/import` accepts a public URL or base64 data. Downloads are protected against reaching private network addresses, size-limited and checked like any upload.

The library uses the same table and card views as Content collections. Switch views beside Display, choose visible details and sort order, search by name or alt text, and filter by file kind or folder. View preferences follow your account. Select files for bulk deletion; selection stays when switching views. Results are paginated, and sorting applies to the full result set. Media pickers use the same views and controls.

Alt text is available in **Display**, and is hidden by default in the overview. Open a file to edit its alt text.

## Media in git

Every item has a small record in `content/media/<id>.yaml`, written whenever you upload, change or delete a file. The files themselves live in `public/media/`. Commit both, and a fresh clone, a reset or a deploy has every image with the same id, alt text and focal point: the `media` table is an index Lettern rebuilds from these files.

```yaml
id: 01m5x9jmrth1ggeatmbzxcz7vk   # lowercase ULID, equals the file name
path: media/2026/10/editor-k3j2.png
name: Editor
folder: screens
alt: The entry editor with a page open
focal: { x: 50, y: 50 }
```

Only `id` and `path` are required: type, size, hash and dimensions are read from the file. A record is held to the same bar as an upload, so one pointing outside `public/media`, at a file of the wrong type or at an SVG with scripts in it is refused. If a record won't parse, nothing is deleted until it's fixed.

Lettern picks up changes on `php cms sync`, at install, before a full build, after any admin request, and when a page asks for an id it doesn't know. Remove a record and the item goes on the next import; the file stays until you delete it.

A `/media/…` URL in an image field gets the same responsive `<picture>` as an id once the file has a record, so a tool that writes files to a fixed path only has to add one. Variant URLs carry a version that changes with the pixels and the focal point, so replaced images never show from a cache.

## Checking for problems

`php cms media:check` imports the records and lists ids and `/media/` URLs that point at nothing, records without a file, files without a record, and items nothing uses. `--strict` exits with an error when something is broken, `--json` prints the report (the `media/report` ability gives the same), and `--adopt` turns files without a record into media items.

`php cms build` prints a warning for every image a page asks for that isn't there, and `--strict` makes those fatal. `media/delete` refuses a file that's still in use and says where; pass `force` to delete it anyway.
