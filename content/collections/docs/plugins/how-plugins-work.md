---
id: 01m5wn8ra7gs5ph45nagmkawqn
title: How plugins work
position: 1
group: 'Build'
description: A plugin is a Composer package with a service provider. It can add abilities, content types, blocks, routes, admin screens — or replace a built-in.
---
## The package

```json
{
    "name": "acme/reviews",
    "description": "Customer reviews with star ratings.",
    "type": "cms-plugin",
    "version": "1.0.0",
    "require": {
        "guzzlehttp/guzzle": "^7.8"
    },
    "autoload": { "psr-4": { "Acme\\Reviews\\": "src/" } },
    "extra": {
        "cms": {
            "label": "Reviews",
            "icon": "star",
            "provider": "Acme\\Reviews\\ReviewsPlugin",
            "provides": ["reviews"],
            "requires": {
                "letterncms/cms": ">=0.1 <2",
                "letterncms/blocks": "*"
            }
        }
    }
}
```

Lettern finds plugins in the site's `plugins/` folder, wherever they came from: `composer require` and the store put them in the same place, `plugins/<name>` for Lettern's own and `plugins/<vendor>-<name>` for anyone else's. `require` decides when a plugin may run: the Lettern version (`letterncms/cms`), other plugins and PHP libraries, with version constraints. If something is missing, the plugin stays off and **Modules** says why. Be careful with `^` before 1.0: `^0.1` stops matching at 0.2, so your plugin would turn off at the next Lettern release. `>=0.1 <1` doesn't.

Lettern's own plugins and everyone else's work identically.

## PHP libraries

A site that uses Composer gets the libraries in your plugin's `require` the normal way. A site set up from the zip has no Composer, so a plugin that needs a library Lettern doesn't already have bundles it. Run `composer install --no-dev` before you zip it and ship its `vendor/`: Lettern reads `vendor/composer/installed.json` to check the constraints in `require`, then loads `vendor/autoload.php`. Files in composer's `autoload.files` load when the plugin starts.

Lettern's own libraries (Laravel, `anthropic-ai/sdk` and the rest of `letterncms/cms`) are shared with every plugin and always win, so a bundled copy can't replace what the core runs on. If two plugins bundle the same library at different versions, whichever loads first is used. Prefix the libraries in your `vendor/` (with [PHP-Scoper](https://github.com/humbug/php-scoper)) to be safe from that; packages sold on the store have to.

## When a plugin fails

A broken plugin stops itself, not the site. If it throws while it loads, registers, boots or migrates, it stays off, plugins that require it stay off, and **Modules** shows the error with its file and line. The error goes to the log as well. The state is kept in `storage/framework/failed-packages.json`.

It starts again when its PHP files or version change, or when you turn it on again in **Modules**. A failure PHP could catch is also retried after five minutes, in case the cause has passed. A fatal error PHP can't catch stops the request it happened in; every later request runs without the plugin. Required modules are part of the admin, so their failures are real errors.

## The provider

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
        $this->cms()->admin()->nav('reviews', ['label' => 'Reviews', 'path' => '/reviews', 'icon' => 'star', 'section' => 'content']);
        $this->cms()->admin()->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star']);
        $this->adminModule();
    }
}
```

Every plugin registers at least one **home-screen widget** — see [Admin extensions](/plugins/admin-extensions#home-screen-widgets). Without one, the plugin keeps running but **Modules** and `cms plugins` report it as invalid.

A provider is a Laravel service provider with Lettern helpers: `$this->cms()` (the Lettern API), `$this->manifest` (the package), `$this->path()`, `$this->settings()`, `$this->asset()` and `$this->adminModule()`.

## What a package can bring

| Folder | Becomes |
|---|---|
| `database/migrations/` | Migrations, run on enable and by `cms sync`. |
| `resources/views/` | Blade views, namespaced by the package name: `reviews::card` — for emails and your own screens, or a block's markup if you prefer Blade. |
| `resources/lang/` | Translations. |
| `dist/` | Built assets, published to `public/_cms/assets/<package>/`. |
| `admin/` | Admin module sources (built to `dist/admin.js`). |

## Lifecycle

| Method | Runs |
|---|---|
| `install()` | Once, after the first migration — seed defaults. |
| `upgrade($from)` | When the package version is newer than the installed one. |
| `uninstall()` | Before migrations are rolled back on uninstall — clean up files and settings. |

Enable, disable and uninstall from **Modules**, the CLI or the `packages/*` abilities. Disabling keeps data; uninstalling removes it.

## Turning a plugin off

Entries that use a plugin's blocks or fields still open and save while it's off, and everything is there when it comes back:

- A block whose plugin is off is kept as it is.
- A field type whose plugin is off is shown as its `fallback` (`['type' => 'media', 'fallback' => 'url']`), and what it stored stays until it's replaced. Without a fallback, the value is kept as JSON.
- A `dynamic` select accepts a name it can't list right now, such as the `menu` source without the navigation plugin. So a wrong name there isn't refused on save; it renders nothing.

Every default plugin is tested this way, off alone and two at a time, with `PluginIsolationTest`.

## Blocks

Register blocks in `boot()`. A block is data — fields, the style sections it offers, whether it holds children — plus a PHP render function:

```php
$this->cms()->whenAvailable(\Cms\Blocks\BlockRegistry::class, fn ($blocks) => $blocks->register([
    'name' => 'reviews/stars',
    'title' => 'Star rating',
    'icon' => 'star',
    'category' => 'data',
    'description' => 'A product’s average rating as stars.',
    'fields' => [
        ['handle' => 'product', 'type' => 'entries', 'label' => 'Product', 'collection' => 'products', 'max' => 1],
    ],
    'render' => fn (array $d) => '<div '.$d['attrs'].' role="img" aria-label="'.e(Reviews::average($d['block']['product'])).' out of 5">'
        .str_repeat(\Cms\Blocks\Icons::svg('star-fill'), (int) round(Reviews::average($d['block']['product'])))
        .'</div>',
]));
```

The render function gets `block` (props, with bindings already applied), `node`, `type`, `content` (rendered children), `attrs` (class, id, data and script attributes for the root element — always print it), `editor` (true for editor rendering), `scope` (the [data](/design/data) in reach) and `renderer`. Everything else — styles on every screen and state, data binding, interactions, animations, the block workspace, the inspector — works for your block without code. `children` (`true` or a list of allowed types), `styles` (style sections, all by default), `inline` (props edited as rich text on the block workspace), `defaults`, `template` (children when inserted), `example` and `view` (a Blade view instead of `render`) complete the definition.

For an inline text property, print `\Cms\Blocks\Elements::editable($d, 'text')` on the element that contains that property, and declare the property in `inline`. This supplies an explicit editing slot in the live output; the editor does not guess which DOM text belongs to a field. The helper identifies editable source properties, exact `entry.title` text bindings and supported declared component-instance text properties. Instance edits write an override on the owning pattern node rather than changing its shared source. Other bindings and generated repeated or sample content remain controlled through their source settings. Always preserve the renderer's root `attrs`, which carry document ownership and selection information.

Component slots support exact `props.<handle>` bindings to declared `text`, `textarea` and `richtext` properties, including exact nested forwarding. They carry an explicit plain-text format because these bindings render escaped text; inline controls must preserve that format rather than introducing rich-text markup. Let `Elements::editable()` produce the ownership, property and resolved-value attributes. Do not infer writable slots from rendered text or add source node IDs to generated component descendants.

Folders of `<name>/block.json` (+ `view.blade.php`) can be added with the `blocks.folders` filter.

## Data sources

A data source is a list the **Repeat** block can loop over — then people design how each item looks. Plugins add them with the `blocks.data-sources` filter:

```php
$this->cms()->hooks()->addFilter('blocks.data-sources', fn (array $sources) => [...$sources, 'reviews' => [
    'label' => 'Reviews',
    'description' => 'Approved reviews of a product, newest first.',
    'fields' => [['handle' => 'limit', 'type' => 'number', 'label' => 'How many', 'default' => 6]],
    'item' => ['author' => 'Author', 'rating' => 'Stars (1–5)', 'text' => 'Review'],
    'resolve' => fn (array $props, \Cms\Blocks\Scope $scope) => Reviews::latest((int) ($props['limit'] ?? 6)),
]]);
```

`fields` are the source's settings in the inspector, `item` documents what each item holds for the binding picker, and `resolve` returns a list of arrays or objects — `item.author`, `item.rating` in the block workspace. `$scope->get('entry')` is the page being rendered. Prefer this to a block with fixed markup: the design stays in the designer's hands. A built page is written again when what it read changes: record your own with `PageContext::depend('reviews')` in `resolve`, and call `SiteBuilder::queueForDependency('reviews')` when your data changes.

To give templates a value of their own, add it to the render scope with the `site.scope` filter (`fn (array $scope, $context) => [...$scope, 'shop' => […]]`) and bind to `shop.*`.

## Collections

A plugin can bring collections — they appear in the admin, use the same field and block workspace, and get every entries ability:

```php
$this->cms()->hooks()->addFilter('collections', fn (array $collections) => $collections + [
    'testimonials' => \Cms\Content\Collections\Collection::fromArray('testimonials', [
        'title' => 'Testimonials', 'driver' => 'files', 'system' => true,
        'fields' => [['handle' => 'quote', 'type' => 'textarea'], ['handle' => 'attribution', 'type' => 'text']],
    ]),
]);
```

`system: true` stops people deleting it; a site can still redefine it with its own `content/collections/<handle>.yaml`. The blocks plugin adds `templates` and `components` exactly this way, with `section: design` so they are listed under **Design** until an admin moves them.

To change the starting definition offered when someone creates a collection, filter `collections.defaults`. `collections/options` returns this definition separately from the settings schema. The blocks plugin contributes a `content` blocks field and its explicit `body` handle; when it is disabled, the browser receives no blocks default and can create a field-only collection. This hook does not change existing collections.

A plugin that stores something per collection offers it as a field in the collection's settings, the same way the site plugin offers the template:

```php
$this->cms()->hooks()->addFilter('collections.settings', fn (array $fields, ?Collection $collection) => [
    ...$fields,
    ['handle' => 'reviews', 'type' => 'toggle', 'label' => 'Allow reviews'],
]);
```

The value is saved in the collection's YAML; read it with `$collection->get('reviews')`.

## Contracts and replacements

Some features are contracts with a default, so a plugin can swap the implementation: `Cms\Contracts\Mailer` (sending email — the mail plugin binds SMTP and API transports), `Cms\Contracts\SiteBuilder` (static publishing). Bind your own in `register()`:

```php
$this->app->singleton(\Cms\Contracts\Mailer::class, PostmarkMailer::class);
```

Plugins that depend on another plugin's service only when it is there use `whenAvailable`:

```php
$this->cms()->whenAvailable(\Cms\Mail\Transports::class, function ($transports) {
    $transports->register('postmark', 'Postmark', $fields, fn (array $settings) => new PostmarkTransport($settings));
});
```
