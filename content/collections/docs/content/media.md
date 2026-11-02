---
id: 01m5wmrf5dhes3ka6256cnzk25
title: Media
position: 3
description: Upload an image once and use it anywhere. Lettern serves it in the right size and format for every screen.
---
The media library holds every image, video and document on your site. Upload a photo once, use it on any page, and Lettern makes the smaller, faster versions each visitor's screen needs.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"You upload one photo. Lettern makes it in several widths, as WebP and AVIF, and each browser picks the one it needs.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-mock\"><i class=\"docs-mock__img\"></i></div><b>Your upload</b><small>One photo, any size</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>480 px</span><em>WebP · AVIF</em></div><div class=\"docs-card docs-card--row\"><span>960 px</span><em>WebP · AVIF</em></div><div class=\"docs-card docs-card--row\"><span>1440 px</span><em>WebP · AVIF</em></div></div><b>Made for you</b><small>Each browser picks the one it needs</small></div></div></figure>"}}
:::

## Upload files

Open **Media** in the sidebar and press **Upload**. You can also upload right from an image field or an Image block, while you pick a file.

Every upload is checked before it's kept:

- The real file type is read from the file itself, not its name.
- SVG images are cleaned of scripts.
- Location and camera details are removed from JPEG photos.
- Uploading the same file twice to the same folder gives you the one you already have.

## Describe each image

Click a file to open it. Fill in its **Alt Text**: a short description of what the image shows, for people using screen readers and for search engines. The SEO checks tell you when a page has images without it.

You can also give the file a clearer **Name**, a **Caption** and a **Folder**, then press **Save**.

## Keep the important part in view

When you open an image, click the spot that matters most, like a face or a plate. That's the **focal point**: whenever the image is cropped, for a square card or a wide banner, that spot stays in frame.

## Find and organize

Put files in folders by typing a folder name when you open them, like `team/2026`. Then narrow the library down:

- **Search** by name or alt text.
- Filter by **Kind**: images, videos, audio, PDFs or other files.
- Pick a **Folder**.

Switch between a grid and a table, and choose what to show and how to sort under **Display**. To find images without a description, show the **Alt Text** column: it marks each image **Added** or **No alt text**. Your view follows you on every device, and the media pickers work the same way.

Select several files to delete them at once. Lettern won't delete a file that's still used on your site, and tells you where it's used.

## Show images on your pages

Add an **Image** block and pick an image. Lettern writes the whole responsive image for you, with its width and height set, so the page never jumps while it loads. Two settings help it load fast:

- **Load First**: turn it on for the main image at the top of a page.
- **Sizes**: how wide the image is shown, so the browser picks the right version, e.g. `(min-width: 64rem) 50vw, 100vw`.

An image can also be a background: select a block and pick one under **Design → Fill → Image**.

## Settings

**Settings → Media** sets the **Maximum Upload Size (MB)**, the **Image Quality**, whether to **Serve AVIF Images** (smaller than WebP, slower to make) and whether to **Remove Photo Metadata (Location, Camera)**. The last two are on unless you turn them off.

## For developers

### Responsive images

Lettern makes WebP and AVIF versions of each image in several widths (480, 960, 1440 and 1920 pixels where the original is wider, plus the original width up to 2560) the first time they're requested, and keeps them in `public/_cms/img/`, so static pages load them without PHP. AVIF needs GD built with AVIF support, or Imagick. Variant URLs carry a version that changes with the pixels and the focal point, so a replaced image never shows from a cache.

The **Image** block renders a complete `<picture>` element. A background image is stored as `media:<id>`; you can also bind `style:backgroundImage` to an image field. To show a field's image, bind the Image block's image to it:

```json
{ "type": "image", "bind": { "image": "entry.hero" } }
```

In PHP, a media field's value renders itself (`(string) $entry->hero`), and offers `img(['sizes' => …, 'priority' => true])` and `src(1200, 'jpg')`.

### Importing from a URL

`media/import` accepts a public URL or base64 data. Downloads can't reach private network addresses, are size-limited and are checked like any upload.

### Media in git

Every item has a small record in `content/media/<id>.yaml`, written whenever you upload, change or delete a file. The files themselves live in `public/media/`. Commit both, and a fresh clone, a reset or a deploy has every image with the same id, alt text and focal point: the `media` table is an index Lettern rebuilds from these files.

```yaml
id: 01m5x9jmrth1ggeatmbzxcz7vk   # lowercase ULID, equals the file name
path: media/2026/10/editor-k3j2.png
name: Editor
folder: screens
alt: The entry editor with a page open
focal: { x: 50, y: 50 }
```

Only `id` and `path` are required: type, size, hash and dimensions are read from the file. A record is held to the same bar as an upload, so one pointing outside `public/media`, at a file of the wrong type or at an SVG with scripts is refused. If a record won't parse, nothing is deleted until it's fixed.

Lettern picks up changes on `php cms sync`, at install, before a full build, after any admin request, and when a page asks for an id it doesn't know. Remove a record and the item goes on the next import; the file stays until you delete it.

A `/media/…` URL in an image field gets the same responsive `<picture>` as an id once the file has a record, so a tool that writes files to a fixed path only has to add one.

### Checking for problems

`php cms media:check` imports the records and lists ids and `/media/` URLs that point at nothing, records without a file, files without a record, and items nothing uses. `--strict` exits with an error when something is broken, `--json` prints the report (the `media/report` ability gives the same), and `--adopt` turns files without a record into media items.

`php cms build` warns about every image a page asks for that isn't there, and `--strict` makes those fatal. `media/delete` refuses a file that's still in use and says where; pass `force` to delete it anyway.
