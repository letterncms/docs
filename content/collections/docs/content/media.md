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

Open **Media** in the sidebar and press **Upload**, or drag files from your desktop onto the library: they land in the folder on view, and the library says where while you hold them over it. You can also upload right from an image field or an Image block, while you pick a file.

Every upload is checked before it's kept:

- The real file type is read from the file itself, not its name.
- SVG images are cleaned of scripts.
- Location and camera details are removed from JPEG photos.
- Uploading the same file twice to the same folder gives you the one you already have.

## Describe each image

Click a file to open it. Fill in its **Alt Text**: a short description of what the image shows, for people using screen readers and for search engines. The SEO checks tell you when a page has images without it.

You can also give the file a clearer **Name** and a **Caption**, then press **Save**. Under **Used In**, the file's details list every page, global and design file that uses it, each linked to where it opens.

## Keep the important part in view

When you open an image, click or tap the spot that matters most, like a face or a plate. That's the **focal point**: whenever the image is cropped, for a square card or a wide banner, that spot stays in frame. You can also drag its marker, or move it with the arrow keys: `Shift` for bigger steps, `Home` for the middle.

## Crop, rotate and replace

Under the picture in a file's details:

- **Crop** takes over the sheet. Pick a **Shape** (**Freeform**, **Original**, **1:1**, **4:3** or **16:9**), then drag the corners or the rectangle, or move a corner with the arrow keys. The focal point stays on what it marked.
- **Rotate** turns the image a quarter turn.
- **Replace File** puts another file of the same kind in its place: a sharper photo, a corrected PDF. The file stays what it was to every page that uses it, with its name, alt text, caption, focal point and folder, and its image sizes are made again.

Crop and rotate work on JPEG, PNG and WebP images.

::: callout {"props":{"tone":"tip","text":"When a file's contents change, its address changes with them, because browsers keep a file for a year by its address. Your pages follow by themselves. Only a link you pasted somewhere outside the site, like a newsletter, still points at the old address."}}
:::

## Find and organize

Folders are a tree beside the files, and a select above them on a phone.

- **New Folder**, under the tree, makes one in the folder on view. A folder can be empty.
- A folder's menu has **Rename** and **Delete Folder**. Deleting a folder deletes no file: its files move to the folder above.
- **Move to Folder** is in a file's menu, in its details, and in the bar when you select several. It shows the tree to choose from, marks the folder the files are in as **Current**, and has **New Folder** right there.

Moving a file doesn't change its address, so nothing on your site notices.

Then narrow the library down:

- **Search** by name or alt text.
- Filter by **Kind**: images, videos, audio, PDFs, 3D models, textures, animations or other files.

Switch between a grid and a table, and choose what to show and how to sort under **Display**. To find images without a description, show the **Alt Text** column: it marks each image **Added** or **No alt text**. Your view follows you on every device, and the media pickers work the same way.

Select several files to move or delete them at once. Lettern won't delete a file that's still used on your site, and names the pages that use it.

A PDF shows its first page on its tile, and a text, CSV or Markdown file shows its first lines. Open the file to read more: a PDF scrolls through its first five pages. Other documents, like Word files, show an icon.

A file says what it is in words, like **Image · JPG**. 3D models, textures and animations show an icon and their kind (GLB, HDR, Lottie) where a picture would be, and their details leave out the image tools.

## Show images on your pages

Add an **Image** block and pick an image. Lettern writes the whole responsive image for you, with its width and height set, so the page never jumps while it loads. Two settings under **Advanced**, in the **Content** tab, help it load fast:

- **Load First**: turn it on for the main image at the top of a page.
- **Shown Width**: how wide the image is shown, so the browser picks the right version, e.g. `(min-width: 64rem) 50vw, 100vw`. Empty means the full width.

An image can also be a background: select a block and pick one under **Design → Fill → Image**.

## Settings

The **Settings** tab of **Media** sets the **Max Upload Size** in MB, with your server's own limit under it, the **Image Quality** (40 to 95), whether to **Serve AVIF Images** (smaller than WebP, slower to make) and whether to **Remove Photo Metadata** (location and camera details). The last two are on unless you turn them off.

## For developers

### Responsive images

Lettern makes WebP and AVIF versions of each image in several widths (480, 960, 1440 and 1920 pixels where the original is wider, plus the original width up to 2560) the first time they're requested, and keeps them in `public/_cms/img/`, so static pages load them without PHP. AVIF needs GD built with AVIF support, or Imagick. Variant URLs carry a version that changes with the pixels and the focal point, so a replaced image never shows from a cache.

The **Image** block renders a complete `<picture>` element. A background image is stored as `media:<id>`; you can also bind `style:backgroundImage` to an image field. To show a field's image, bind the Image block's image to it:

```json
{ "type": "image", "bind": { "image": "entry.hero" } }
```

In PHP, a media field's value renders itself (`(string) $entry->hero`), and offers `img(['sizes' => …, 'priority' => true])` and `src(1200, 'jpg')`.

### Files for scenes and animation players

The library also keeps what a script loads by address, for a 3D scene or an animation player. Each kind is recognized by its contents, not its name, and has a size limit of its own; the site's **Max Upload Size** still applies when it is lower.

| File | Kind | Limit |
|---|---|---|
| `.glb` | 3D model (binary glTF) | 64 MB |
| `.gltf` | 3D model, with its data embedded | 8 MB |
| `.hdr` | Environment map (Radiance HDR) | 32 MB |
| `.ktx2` | GPU texture | 32 MB |
| `.json` | Lottie animation | 4 MB |
| `.riv` | Rive file | 16 MB |

Some are refused, with the reason, also when the file arrives by git or FTP:

- A model that points at other files, which it wouldn't find: export it as one `.glb` with everything inside.
- A Lottie animation with expressions, with fonts to load, or with images that aren't embedded.
- A `.json` file that is not a Lottie animation.

In the library they are kinds of their own: `model`, `texture` and `animation`. None of them is resized or converted. They are served with their own type and cached for a year: a media file's name never gets new contents. A [block behavior](/design/behaviors) loads one by its address under `/media/`, with a library added through [`cms vendor`](/design/code#add-a-library), such as Three.js, lottie-web or Rive.

### Folders, replacing and cropping through abilities

| Ability | Does |
|---|---|
| `media/list` | Takes `folder` (one folder's own files, `''` for files in none) and `kind` (`image`, `video`, `audio`, `pdf`, `model`, `texture`, `animation`, `file`), and answers with the whole tree of folder paths in `folders`, empty ones included |
| `media/get` | One file with `usedBy`: every entry, global and design file that uses it |
| `media/move` | Puts files in a folder by its path: `{"ids": ["…"], "folder": "press/2026"}`. `''` takes them out of every folder, and a folder that isn't there is made |
| `media-folders/create`, `media-folders/rename`, `media-folders/delete` | Makes an empty folder by its path, gives one a new name or place, or deletes one (its files move up) |
| `media/replace` | Puts another file in an item's place, from a URL or base64 data. It must be of the same kind |
| `media/transform` | `rotate` by 90, 180 or 270 degrees, `crop` to a rectangle in pixels of the rotated image, or both |

Folders someone made are kept in `content/media/folders.json`, beside the records, so empty ones survive too.

`media/replace` and `media/transform` change a file's bytes, so its address changes: `/media/team/harbour.jpg` becomes `/media/team/harbour-tr3z.jpg`. What uses the file by its id needs nothing, and content that names the old address is rewritten to the new one. Both ask first, and a dry run checks the file itself and lists what would be rewritten:

```bash
php cms run media/transform --dry-run --input='{"id":"01m75v6ghkdx5w8njb30bn5xja","rotate":90,"crop":{"x":0,"y":0,"width":400,"height":400}}'
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "media/transform",
        "checked": "full",
        "input": { "id": "01m75v6ghkdx5w8njb30bn5xja", "rotate": 90, "crop": { "x": 0, "y": 0, "width": 400, "height": 400 } },
        "changes": [
            {
                "action": "transform",
                "type": "media",
                "id": "01m75v6ghkdx5w8njb30bn5xja",
                "path": "media/team/harbour.jpg",
                "rotate": 90,
                "crop": { "x": 0, "y": 0, "width": 400, "height": 400 },
                "from": { "width": 800, "height": 600 },
                "to": { "width": 400, "height": 400 }
            },
            { "action": "update", "type": "entry", "id": "01m75v6w9taawe8mjhhzyxvfe0", "path": "content.0.props.image.0" }
        ]
    }
}
```

`POST /api/v1/media/upload` takes `replace` with an item's id and runs `media/replace`, so a replaced file is in the audit log like every change. Deleting a file that is used is refused with `conflict`: `This file is still used by Dusk.`

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

Lettern picks up changes on `php cms migrate`, at install, before a full build, after any admin request, and when a page asks for an id it doesn't know. Remove a record and the item goes on the next import; the file stays until you delete it.

A `/media/…` URL in an image field gets the same responsive `<picture>` as an id once the file has a record, so a tool that writes files to a fixed path only has to add one.

### Checking for problems

`php cms media:check` imports the records and lists ids and `/media/` URLs that point at nothing, records without a file, files without a record, and items nothing uses. `--strict` exits with an error when something is broken, `--json` prints the report as JSON, under `data` (the `media/report` ability gives the same), and `--adopt` turns files without a record into media items.

`php cms build` warns about every image a page asks for that isn't there, and `--strict` makes those fatal. `media/delete` refuses a file that's still in use and says where; pass `force` to delete it anyway.
