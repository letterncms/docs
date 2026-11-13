---
id: 01m5wn8ra7gs5ph45nagmkawqn
title: How plugins work
position: 1
description: What a plugin package holds, how Lettern starts it, and everything it can add, from blocks to collections.
---
A plugin is a Composer package with one PHP class, its **provider**. Lettern finds the package in your site's `plugins/` folder, checks what it needs, and runs the provider, which adds abilities, blocks, settings, admin screens or anything else.

Lettern's own features, like the page builder, forms and SEO, are plugins built exactly this way. Anything they do, yours can do too.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A plugin is a folder in plugins/ with composer.json, a provider and its built admin code. When it is turned on, its migrations run and install() is called once. On every request, Lettern checks what it needs and calls register() and boot().\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>acme-reviews/</b><span class=\"docs-card__field\">composer.json</span><span class=\"docs-card__field\">src/ReviewsPlugin.php</span><span class=\"docs-card__field\">dist/admin.js</span><span class=\"docs-card__field\">lang/</span></div><b>The package</b><small>A folder in plugins/</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Turned on</b><span class=\"docs-card__field\">Migrations run</span><span class=\"docs-card__field\">install()</span></div><b>Once</b><small>Or upgrade() for a new version</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Running</b><span class=\"docs-card__field\">Requirements checked</span><span class=\"docs-card__field\">register()</span><span class=\"docs-card__field\">boot()</span></div><b>Every request</b><small>Adds abilities, blocks, screens</small></div></div></figure>"}}
:::

New to plugins? [Your first plugin](/plugins/your-first-plugin) builds a complete one, step by step.

## A minimal plugin

Two files make a working plugin. `composer.json` says who it is:

```json
{
    "name": "acme/reviews",
    "type": "cms-plugin",
    "version": "1.0.0",
    "require": { "letterncms/cms": ">=0.7 <1" },
    "autoload": { "psr-4": { "Acme\\Reviews\\": "src/" } },
    "extra": { "cms": { "label": "Reviews", "provider": "Acme\\Reviews\\ReviewsPlugin" } }
}
```

And `src/ReviewsPlugin.php` adds what it brings:

```php
<?php

namespace Acme\Reviews;

use Cms\Packages\Plugin;

final class ReviewsPlugin extends Plugin
{
    public function boot(): void
    {
        $this->cms()->admin()->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star']);
    }
}
```

Put the folder in `plugins/`, turn it on with its switch in **Plugins** or with `php cms plugin enable acme/reviews`, and it runs. This one registers a Dashboard widget, which a plugin does when it has something worth a glance; what the widget shows comes from your admin code, in [Admin extensions](/plugins/admin-extensions#dashboard-widgets).

## The package

`composer.json` is an ordinary Composer file, with `type: cms-plugin` and Lettern's part under `extra.cms`:

```json
{
    "name": "acme/reviews",
    "description": "Customer reviews with star ratings.",
    "type": "cms-plugin",
    "version": "1.0.0",
    "require": {
        "letterncms/cms": ">=0.9 <1",
        "guzzlehttp/guzzle": "^7.8"
    },
    "autoload": { "psr-4": { "Acme\\Reviews\\": "src/" } },
    "extra": {
        "cms": {
            "label": "Reviews",
            "icon": "star",
            "provider": "Acme\\Reviews\\ReviewsPlugin",
            "modules": ["letterncms/blocks"]
        }
    }
}
```

| Key in `extra.cms` | Meaning |
|---|---|
| `label` | The plugin's name in the admin: its row in **Plugins**, and the name its screen and settings page take unless they give their own. Defaults to the package name, in words. |
| `icon` | Its icon in **Plugins**. |
| `provider` | The class Lettern starts. A package without one can still bring migrations, views and translations. |
| `namespace` | The name for its settings, views and translations. Defaults to the part after the slash (`reviews`). |
| `modules` | The optional [modules](/plugins/modules) it builds on, such as `letterncms/blocks` or `letterncms/site`. They come with Lettern, so they aren't in `require`. |
| `sync` | How [Sync](/plugins/sync) treats its tables. |

### Where plugins live

Lettern finds plugins in the site's `plugins/` folder, wherever they came from. `composer require` and the store put them in the same place: `plugins/<name>` for Lettern's own and `plugins/<vendor>-<name>` for anyone else's. Lettern's own plugins and everyone else's work identically.

### Requirements

`require` decides when a plugin may run: the Lettern version (`letterncms/cms`), other plugins and PHP libraries, with version constraints. `extra.cms.modules` adds the modules it builds on. If something is missing or off, the plugin stays off and **Plugins** says why. A plugin can only be turned on after the plugins and modules it needs, and those can't be turned off while it's on: their switch is grayed out, with the reason.

::: callout {"props":{"tone":"warning","text":"Be careful with <code>^</code> before 1.0: <code>^0.7</code> stops matching at 0.8, so your plugin would turn off at the next Lettern release. <code>&gt;=0.7 &lt;1</code> doesn't."}}
:::

## The provider

A provider is a Laravel service provider with Lettern helpers. Bind your own services in `register()`, and add everything else in `boot()`:

```php
namespace Acme\Reviews;

use Cms\Packages\Plugin;

final class ReviewsPlugin extends Plugin
{
    public function register(): void
    {
        $this->app->singleton(Reviews::class);
    }

    public function boot(): void
    {
        $this->cms()->permissions()->register('reviews.manage', 'Moderate reviews', 'Reviews');
        $this->cms()->abilities()->register('reviews/list', [/* … */]);
        $this->cms()->hooks()->on('entry.published', fn ($entry) => /* … */ null);
        $this->cms()->admin()->nav('reviews', ['path' => '/reviews', 'icon' => 'star', 'section' => 'content']);
        $this->cms()->admin()->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star']);
        $this->adminModule();
    }
}
```

| Helper | Gives you |
|---|---|
| `$this->cms()` | The Lettern API, below. `cms()` is the same thing anywhere else. |
| `$this->manifest` | The package, as read from `composer.json`. |
| `$this->path('…')` | A path inside the package. |
| `$this->setting('key', $default)` | A value of the plugin's own [settings](/plugins/settings). |
| `$this->asset('file')` | The public URL of a file in its `dist/`. |
| `$this->adminModule()` | Loads its built admin code, `dist/admin.js` (and `dist/admin.css` when there is one). See [Admin extensions](/plugins/admin-extensions). |

`$this->cms()` is where everything is registered: `abilities()`, `hooks()`, `permissions()`, `settingsRegistry()` and `setting()`, `admin()`, `adminNav()`, `skills()`, `fields()`, `collections()`, `entries()` and `entryService()`, `globals()`, `accounts()`, `roles()`, `packages()` and `whenAvailable()`. `url('/pricing')` is an absolute address on the public site, from **Public URL** under **Settings → General**.

A permission can belong to the roles a site starts with: `roles: ['editor']` (or `['editor', 'author']`) gives it to those default roles until the site edits its roles. Administrators hold every permission anyway.

```php
$this->cms()->permissions()->register('reviews.manage', 'Moderate reviews', 'Reviews', roles: ['editor']);
```

Write labels and groups in English, as plain strings: the admin shows them in each person's language.

### A widget, when there is something to show

A plugin registers a **Dashboard widget** when it has something worth a glance: see [Admin extensions](/plugins/admin-extensions#dashboard-widgets). A plugin without one is as good as any, and a widget with nothing to say draws nothing.

## What a package can bring

Besides the provider, a few folders are picked up by name:

| Folder | Becomes |
|---|---|
| `database/migrations/` | Migrations, run when the plugin is turned on and by `cms migrate`. |
| `resources/views/` | Blade views, namespaced by the plugin: `reviews::card`. For emails and your own screens, or a block's markup if you prefer Blade. |
| `resources/lang/` | Laravel translation files, in the same namespace. |
| `lang/` | `<code>.json` translations for the admin and `__()`. See [Translations](/plugins/admin-extensions#translations). |
| `dist/` | Built assets, published to `public/_cms/assets/<vendor>-<name>/`. |
| `admin/` | Admin module sources, built to `dist/admin.js`. |

## Install, upgrade, uninstall

Three optional methods on the provider run at the moments that matter:

| Method | Runs |
|---|---|
| `install()` | Once, after the first migration. Seed defaults here. |
| `upgrade($from)` | When the package version is newer than the installed one. |
| `uninstall()` | Before migrations are rolled back on uninstall. Clean up files and settings. |

Turn a plugin on or off with its switch in **Plugins**, uninstall it from its row's menu, or use `php cms plugin enable|disable|uninstall <name>` or the `packages/*` abilities. Disabling keeps the data; uninstalling removes it.

## When a plugin is off

Entries that use a plugin's blocks or fields still open and save while it's off, and everything is there when it comes back:

- A block whose plugin is off is kept as it is, with its settings, its styles and the blocks inside it, through saving, Block Markdown and the API. The site shows nothing of it, nor of the blocks inside it, which may only make sense in it. The build does not warn about it: a plugin that is off was turned off on purpose.
- On the canvas, such a block shows its name and its plugin's: **Player block — its plugin, Video, is turned off**, or **is not installed**. It can be selected, moved and deleted, and its settings are shown read-only.
- Settings a newer version of a block no longer has are kept, not dropped.
- Uninstalling a plugin removes its data, never content: the confirmation says how many entries use its blocks. Those blocks come back as they were when the plugin is installed again.
- A field whose type's plugin is off keeps its value, as JSON.
- A `dynamic` select accepts a name it can't list right now, such as a form while the Forms plugin is off. So a wrong name there isn't refused on save; it renders nothing.

Every default plugin is tested this way, off alone and two at a time, with `PluginIsolationTest`.

## When a plugin fails

A broken plugin stops itself, not the site. If it throws while it loads, registers, boots or migrates, it stays off, plugins that require it stay off, and **Plugins** shows the error with its file and line. The error goes to the log as well. The state is kept in `storage/framework/failed-packages.json`.

It starts again when its PHP files or version change, or when you turn it on again in **Plugins**. A failure PHP could catch is also retried after five minutes, in case the cause has passed. A fatal error PHP can't catch stops the request it happened in; every later request runs without the plugin. Required [modules](/plugins/modules) are part of the admin, so their failures are real errors.

A block whose render function throws is left out of the page, and the page still builds. The log names the block's type, its id and the page, the build lists it among its warnings (`php cms build --strict` fails on them), and the canvas shows the error in the block's place.

## PHP libraries

A site that uses Composer gets the libraries in your plugin's `require` the normal way. A site set up from the zip has no Composer, so a plugin that needs a library Lettern doesn't already have bundles it:

1. Run `composer install --no-dev` in the plugin before you zip it.
2. Ship its `vendor/`. Lettern reads `vendor/composer/installed.json` to check the constraints in `require`, then loads `vendor/autoload.php`.

Files in Composer's `autoload.files` load when the plugin starts.

Lettern's own libraries (Laravel, `anthropic-ai/sdk` and the rest of `letterncms/cms`) are shared with every plugin and always win, so a bundled copy can't replace what the core runs on. If two plugins bundle the same library at different versions, whichever loads first is used. Prefix the libraries in your `vendor/` with [PHP-Scoper](https://github.com/humbug/php-scoper) to be safe from that; packages sold on the store have to.

## Blocks

A block is data (its fields, the style sections it offers, whether it holds children) plus a PHP render function. Register blocks in `boot()`:

```php
$this->cms()->whenAvailable(\Cms\Modules\Blocks\BlockRegistry::class, fn ($blocks) => $blocks->register([
    'name' => 'reviews/stars',
    'title' => 'Star rating',
    'icon' => 'star',
    'category' => 'data',
    'description' => 'A product’s average rating as stars.',
    'fields' => [
        ['handle' => 'product', 'type' => 'entries', 'label' => 'Product', 'collection' => 'products', 'max' => 1],
    ],
    'render' => fn (array $d) => '<div '.$d['attrs'].' role="img" aria-label="'.e(Reviews::average($d['block']['product'])).' out of 5">'
        .str_repeat(\Cms\Modules\Blocks\Icons::svg('star-fill'), (int) round(Reviews::average($d['block']['product'])))
        .'</div>',
]));
```

Everything else works for your block without code: styles on every screen and state, data binding, interactions, animations, the block workspace and the inspector.

### What the render function gets

| Key | Holds |
|---|---|
| `block` | The props, with bindings already applied. |
| `attrs` | Class, id, data and script attributes for the root element. Always print it: it carries document ownership and selection. |
| `content` | The rendered children. |
| `node`, `type` | The block's node and its type. |
| `editor` | `true` when rendering for the editor. |
| `scope` | The [data](/design/data) in reach. |
| `renderer` | The renderer. |

### The rest of the definition

| Key | Meaning |
|---|---|
| `children` | `true`, or a list of allowed types. |
| `styles` | The style sections it offers; all by default. |
| `inline` | Props edited as rich text on the block workspace. |
| `defaults` | Starting props. |
| `template` | Children when inserted. |
| `example` | Example props, listed for agents in the block catalog (`blocks/types`). |
| `view` | A Blade view instead of `render`. |
| `uses` | Browser features (below) that every page showing the block needs. |

Folders of `<name>/block.json` (plus `view.blade.php`) can be added with the `blocks.folders` filter.

The core's own Audio, Gallery, Carousel and File blocks are added this way, through the same registry and the same features, so they are good examples (`Cms\Modules\Blocks\MediaBlocks`).

### Scripts and styles for your blocks

A block that needs its own stylesheet, or a script in the browser, names a **feature**. Register it with the files your build puts in `dist/`, and a page loads them only when a block on it uses the feature:

```php
$this->cms()->whenAvailable(\Cms\Modules\Blocks\BlockRegistry::class, function ($blocks) {
    $blocks->feature('reviews/stars', style: $this->asset('stars.css').'?v=2');
    $blocks->feature('reviews/slider', script: $this->asset('slider.js').'?v=2', style: $this->asset('slider.css').'?v=2');

    $blocks->register([
        'name' => 'reviews/stars',
        'uses' => ['reviews/stars'],
        // …
        'render' => function (array $d) {
            if (! empty($d['block']['slide'])) {
                $d['renderer']->uses('reviews/slider');
            }

            return '<div '.$d['attrs'].'>…</div>';
        },
    ]);
});
```

- `uses` in the definition loads a feature on every page that shows the block. `$d['renderer']->uses()` loads it only when the block asks for it while it renders, for a setting that needs a script.
- A feature's files are addresses on the site, such as `$this->asset()` gives you. Put a version in each one (`?v=…`, or a hash in the file's name), so browsers fetch the new file after an update.
- The stylesheet goes in the page's head. Write it in `@layer components`, as the core's blocks do, so the builder's styles win over it.
- The script is an ES module that exports `start()`. The page loads it beside Lettern's own runtime. `start()` runs once the module has loaded, and again when a page arrives without a page load, so look for your blocks each time and skip the ones you already set up. A script that fails to load or throws stops only its own feature: the page's other features run, and your blocks stay as they are without scripts. Make them work that way, as a link or a plain row, and let the script add the rest.
- In the block workspace, every feature's stylesheet is loaded and no script runs.
- A name is your plugin's own, like `reviews/slider`. The runtime's names (`motion`, `logic`, `search`…) are taken.

### Empty blocks on the canvas

While nothing is chosen yet, show the block's shape on the canvas only, and print nothing on the site. `$d['editor']` tells you which one you're rendering for. `\Cms\Modules\Blocks\Elements::mediaPlaceholder($d, 'image', '16/9')` draws a quiet stand-in with an icon, in the shape the block will have. `Elements::placeholder($d, 'text')` gives an empty inline property the muted text from `placeholders` (or its field label).

### Text people edit on the page

For an inline text property, declare it in `inline` and print `\Cms\Modules\Blocks\Elements::editable($d, 'text')` on the element that holds it. This gives the editor an explicit editing slot in the live output: it never guesses which text belongs to a field.

The helper identifies editable source properties, exact `entry.title` text bindings and supported declared component-instance text properties. Instance edits write an override on the owning pattern node rather than changing its shared source. Other bindings and generated repeated or sample content stay controlled through their source settings.

Component slots support exact `props.<handle>` bindings to declared `text`, `textarea` and `richtext` properties, including exact nested forwarding. They carry an explicit plain-text format, because these bindings render escaped text; inline controls must keep that format rather than introduce rich-text markup. Let `Elements::editable()` produce the ownership, property and resolved-value attributes. Don't infer writable slots from rendered text, and don't add source node IDs to generated component descendants.

### Patterns and components

A plugin can ship ready-made arrangements of its blocks. [Patterns](/design/patterns) are copied into a page when someone inserts one. Add folders of them with the `blocks.pattern-sources` filter: each `<handle>.md` has front matter (`title`, `category`, `description`, `keywords`) and the blocks in Block Markdown.

```php
$this->cms()->hooks()->addFilter('blocks.pattern-sources', fn (array $sources) => [
    ...$sources,
    ['path' => $this->path('patterns'), 'source' => 'acme/reviews'],
]);
```

[Components](/design/components) stay linked to every page that uses them. Ship those with `blocks.component-sources`, as folders of `<handle>.json`. Both kinds are read-only: people insert them, and save a copy under a name of their own to change one.

## Data sources

A data source is a list the **Repeat** block can loop over, so designers decide how each item looks. Add one with the `blocks.data-sources` filter:

```php
$this->cms()->hooks()->addFilter('blocks.data-sources', fn (array $sources) => [...$sources, 'reviews' => [
    'label' => 'Reviews',
    'description' => 'Approved reviews of a product, newest first.',
    'fields' => [['handle' => 'limit', 'type' => 'number', 'label' => 'How many', 'default' => 6]],
    'item' => ['author' => 'Author', 'rating' => 'Stars (1–5)', 'text' => 'Review'],
    'resolve' => fn (array $props, \Cms\Modules\Blocks\Scope $scope) => Reviews::latest((int) ($props['limit'] ?? 6)),
]]);
```

- `fields` are the source's settings in the inspector.
- `item` documents what each item holds, for the binding picker: `item.author`, `item.rating` in the block workspace.
- `resolve` returns a list of arrays or objects. `$scope->get('entry')` is the page being rendered.

Prefer this to a block with fixed markup: the design stays in the designer's hands.

`Cms\Modules\Site\Rendering\PageContext::current()` is the page being rendered (its `entry`, `uri` and `locale()`), or null outside one. A built page is written again when what it read changes. Record your own dependency with `PageContext::depend('reviews')` in `resolve`, and call `SiteBuilder::queueForDependency('reviews')` when your data changes.

To give templates a value of their own, add it to the render scope with the `site.scope` filter (`fn (array $scope, $context) => [...$scope, 'shop' => […]]`) and bind to `shop.*`.

## Collections

A plugin can bring collections. They appear in the admin, use the same fields and block workspace, and get every entries ability:

```php
$this->cms()->hooks()->addFilter('collections', fn (array $collections) => $collections + [
    'testimonials' => \Cms\Content\Collections\Collection::fromArray('testimonials', [
        'title' => 'Testimonials', 'driver' => 'files', 'system' => true,
        'fields' => [['handle' => 'quote', 'type' => 'textarea'], ['handle' => 'attribution', 'type' => 'text']],
    ]),
]);
```

`system: true` keeps it out of **Collections** and stops people deleting it; a site can still redefine it with its own `content/collections/<handle>.yaml`. The Blocks module adds `templates` and `components` exactly this way, with `section: design`, so they are listed under **Design** in the sidebar.

### The starting definition

To change the definition offered when someone creates a collection, filter `collections.defaults`. `collections/options` returns this definition separately from the settings schema. The Blocks module contributes a `content` blocks field marked `body: true`; when it's off, the browser receives no blocks default and can create a field-only collection. This hook doesn't change existing collections.

### A setting per collection

A plugin that stores something per collection offers it as a field in the collection's settings, the same way Site offers the template:

```php
$this->cms()->hooks()->addFilter('collections.settings', fn (array $fields, ?Collection $collection) => [
    ...$fields,
    ['handle' => 'reviews', 'type' => 'toggle', 'label' => 'Allow reviews'],
]);
```

The value is saved in the collection's YAML; read it with `$collection->get('reviews')`.

## Replace a built-in

Some features are contracts with a default, so a plugin can swap the implementation: `Cms\Contracts\SiteBuilder` (static publishing; Site binds it), `Cms\Contracts\Agent` (see [Agents](/plugins/agents)) and `Cms\Contracts\Translator` (the machine translation Languages offers: `available()` and `translate(array $strings, string $from, string $to): array`, which returns as many strings in the same order; the assistant binds Claude). Bind your own in `register()`:

```php
$this->app->singleton(\Cms\Contracts\SiteBuilder::class, NetlifyBuilder::class);
```

Email isn't swapped: a plugin adds a way to send it, below.

## Build on another plugin

To use another plugin's or a module's service only when it's there, use `whenAvailable`. Your plugin keeps working without it:

```php
$this->cms()->whenAvailable(\Cms\Modules\Email\Transports::class, function ($transports) {
    $transports->register('postmark', 'Postmark', $fields, fn (array $settings) => new PostmarkTransport($settings));
});
```
