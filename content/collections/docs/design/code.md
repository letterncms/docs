---
id: 01m75f2pvmp4endmxx1t3m2qy6
title: Scripts and styles
position: 7
description: 'Your own JavaScript and CSS beside the design, and the libraries they import, without a bundler.'
---
Most sites never need code: tokens, blocks, animations and interactions cover them. An ambitious front end does. A scroll timeline in GSAP, a WebGL scene, smooth scrolling: for these a site keeps its own scripts and stylesheets beside the design, and the libraries they use beside those.

There is no build step of your own. You write ES modules and plain CSS, say where each loads, and the site publishes them.

## Where the files are

| File | What it is |
|---|---|
| `content/design/scripts/<name>.js` | An ES module. Folders are allowed: `scripts/lib/ease.js` is the script `lib/ease` |
| `content/design/styles/<name>.css` | A stylesheet |
| `content/design/code.json` | Which of them load where |
| `content/design/vendor/` | Libraries the scripts import by name, with `lock.json` |
| `content/design/custom.css`, `custom.js` | One file each, on every page, as before. See [Custom CSS and JavaScript](/design/site-design#custom-css-and-javascript) |

A name is lowercase letters, digits, `-` and `_`, in up to three folders.

In the admin, all of it is under **Design → Code**: **Styles** and **Scripts** each start with the site's own file (**Site CSS**, **Site JavaScript**) and list the other files under it, and **Libraries** lists what the scripts import. Changing any of it needs the **Edit Custom CSS and JavaScript** permission, which is **Trusted Only**.

## Say where a file loads

A file does nothing until something loads it. There are four places to say so, from widest to narrowest:

| Loads | How |
|---|---|
| On every page | `scripts` and `styles` at the top of `code.json` |
| With a template | `templates.<handle>` in `code.json` |
| On pages that show a component | `components.<handle>` in `code.json` |
| With one block | `code` on the block: `{"scripts": ["hero"], "styles": ["hero"]}` |

```json
{
  "scripts": ["smooth"],
  "styles": ["base"],
  "templates": { "post": { "styles": ["article"] } },
  "components": { "header": { "scripts": ["menu"] } }
}
```

A script that should run on one element, and stop when that element leaves, is a [block behavior](/design/behaviors): the block names it and nothing in `code.json` is needed.

Scripts load as `<script type="module">` at the end of the page, and never in the editor. Each file is published once under `/_cms/site/scripts/` or `/_cms/site/styles/` with a hash of its contents in its name, so browsers cache it forever. Changing a file rebuilds only the pages that load it. A page carries at most 40 scripts and 40 stylesheets.

One script imports another by its path:

```javascript
import { ease } from './lib/ease.js'
```

The page's import map sends that path to the published file.

## Add a library

`cms vendor` keeps the libraries. It fetches a package's ES module at one exact version from jsDelivr into `content/design/vendor/`, and from then on the site serves the file itself.

```bash
php cms vendor add gsap@3.12.5
php cms vendor add gsap@3.12.5 --file=ScrollTrigger.js --as=gsap/ScrollTrigger
php cms vendor add three@0.160.0
```

```
   INFO  gsap 3.12.5: import … from "gsap".

   INFO  gsap/ScrollTrigger 3.12.5: import … from "gsap/ScrollTrigger".

   INFO  three 0.160.0: import … from "three".
```

Scripts then import it by that name:

```javascript
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
```

`--file=` takes one file of a package instead of its main entry, and `--as=` sets the name scripts import it by. A version must be exact. A range is refused:

```
   ERROR  Name one exact version, like gsap@1.2.3. A range would give a different library on another day.
```

| Command | Does |
|---|---|
| `cms vendor add <name>@<version>` | Fetches the library and locks it |
| `cms vendor list` | Lists each import with its package, version and hash |
| `cms vendor update <import> [version]` | Moves an import to another exact version, or to the newest one |
| `cms vendor remove <import>` | Takes the import and its files out. Refused while another import needs it |

```
+--------------------+---------------+------------------+-------+-------------------------------------------------------------------------+
| Import             | Package       | File             | Files | Integrity                                                               |
+--------------------+---------------+------------------+-------+-------------------------------------------------------------------------+
| gsap               | gsap@3.12.5   |                  | 1     | sha384-vkCa24FZ2iw7n39KNqsCLcRKGU7GY3gM8+ztg7CPwPXjW4lwnCeheje/9a8EXfR8 |
| gsap/ScrollTrigger | gsap@3.12.5   | ScrollTrigger.js | 1     | sha384-hTRyLLVdWL6gKI7rHNS4v5D8Y7r+4rm8niY2v/zcnXpuM/HYil0jXP7X8olkjDUB |
| three              | three@0.160.0 |                  | 1     | sha384-WcFSC1gWChTPqIxbDB7SxeqxQMtt3NKNwUJj5wR/UYR7QF8F86fuAFG+8ZEe0m2d |
+--------------------+---------------+------------------+-------+-------------------------------------------------------------------------+
```

In the admin, **Libraries** under **Design → Code** does the same: **Add Library** takes `name@version`, and each row has **Update** and **Remove**.

Commit `content/design/vendor/` with the rest of the design. The files and the lock travel together, so another checkout serves the same libraries without fetching anything.

### The lock and the import map

`content/design/vendor/lock.json` records, for each import, the package, the exact version, where it came from, and a `sha384` hash of every file it brought:

```json
{
    "imports": {
        "gsap": {
            "package": "gsap",
            "version": "3.12.5",
            "source": "https://cdn.jsdelivr.net/npm/gsap@3.12.5/+esm",
            "path": "gsap@3.12.5/index.js",
            "files": {
                "gsap@3.12.5/index.js": "sha384-vkCa24FZ2iw7n39KNqsCLcRKGU7GY3gM8+ztg7CPwPXjW4lwnCeheje/9a8EXfR8"
            }
        }
    }
}
```

A page that loads a script gets an import map before its first module. It names every library with the hash its file must have, and every script of the design with its published file:

```html
<script type="importmap">{"imports":{"gsap":"/_cms/site/vendor/gsap@3.12.5/index.js","/_cms/site/scripts/timeline.js":"/_cms/site/scripts/timeline-6f669f87e9.js"},"integrity":{"/_cms/site/vendor/gsap@3.12.5/index.js":"sha384-vkCa24FZ…"}}</script>
```

A page without scripts has no import map.

What keeps this safe:

- A library is fetched once, when you add or update it. Visitors only ever load it from your site.
- A build of a library that would still import from the CDN or from another address is refused when you add it. So is one that brings more than 40 files: add the parts you need one by one with `--file=`.
- A file in `vendor/` that no longer matches its hash in the lock is not published, and the build warns: run `cms vendor add` again.
- Nothing checks what your own scripts import. Don't import a library from a CDN in a script: add it with `cms vendor`.
- What a library requests once it runs is up to the library.

## For developers

### Abilities

Agents and scripts do all of the above through abilities. Reading the lists needs only access to the admin; reading or changing a file's contents, and changing libraries, needs `site.code`.

| Ability | Does |
|---|---|
| `design-code/list` | The scripts and styles by name, and `load`: what `code.json` holds |
| `design-code/get` | The contents of one file: `{"path": "scripts/hero.js"}` |
| `design-code/save` | Creates or replaces a file: `{"path": "styles/hero.css", "contents": "…"}` |
| `design-code/delete` | Removes a file, and what was published of it |
| `design-code/set-load` | Replaces `code.json` |
| `design-code/set-custom` | Replaces `custom.css` or `custom.js` |
| `design-vendor/list` | The libraries: import, package, version, source, URL and hash |
| `design-vendor/create` | `cms vendor add`: `{"package": "gsap@3.12.5"}`, with `file` and `as` |
| `design-vendor/update` | `cms vendor update`: `{"import": "gsap", "version": "3.13.0"}` |
| `design-vendor/delete` | `cms vendor remove`: `{"import": "gsap"}` |

```bash
php cms run design-code/set-load --input='{"styles":["scene"]}'
```

```json
{
    "data": {
        "scripts": ["scene", "spotlight", "timeline"],
        "styles": ["scene", "spotlight"],
        "load": {
            "scripts": [],
            "styles": ["scene"],
            "templates": {},
            "components": {}
        }
    }
}
```

The context resource `cms://site/code` gives an agent the same lists with the rules on this page.

### Minimal's example

A new site, from the kit Minimal, comes with one script and one stylesheet: `scripts/spotlight.js` and `styles/spotlight.css`, a soft light behind the home page's first section that follows the pointer. It shows where the files go and how a block names them. To be rid of it, delete the two files and the section's `behavior` and `code`.

See [A pinned scroll scene and a 3D canvas](/design/front-end-example) for all of this working together.
