---
id: 01m5wnc9yk953jb0ypst9kxxwz
title: Settings
position: 3
description: List a few fields, and your plugin gets a settings screen, an API, environment overrides and encrypted secrets.
---
Most plugins need a few options: an API key, a limit, a switch. In Lettern you list the fields, and the rest comes for free: a page under **Settings**, saving and validation, abilities for scripts and agents, and safe storage for secrets.

## Add a settings page

Register the fields in your provider's `boot()`:

```php
$this->cms()->settingsRegistry()->register('reviews', 'Reviews', [
    ['handle' => 'moderation', 'type' => 'toggle', 'label' => 'Hold new reviews for approval', 'default' => true],
    ['handle' => 'min_rating', 'type' => 'number', 'label' => 'Hide reviews below', 'default' => 1, 'min' => 1, 'max' => 5],
    ['handle' => 'api_key', 'type' => 'text', 'label' => 'Trustpilot API key', 'secret' => true],
], icon: 'star', description: 'How reviews are collected and shown.', package: $this->manifest->name, permission: 'reviews.manage');
```

That's all it takes for **Settings → Reviews** to appear, under **Site** in the settings sidebar.

![The SEO plugin's settings page: a form drawn from the fields the plugin registered.](/media/screens/plugins-settings.webp "The SEO plugin's settings are a list of fields like this one.")

Fields use the same format as everywhere else in Lettern, including `if` conditions, `width` and `dynamic` options. See [Field types](/reference/field-types).

### Options

| Argument | Meaning |
|---|---|
| `$namespace` | The settings' name: `reviews` is saved to `config/reviews.yaml`. |
| `$label` | The page's title in the settings sidebar. |
| `$fields` | The fields. |
| `icon`, `description` | How the page is shown. |
| `package` | The plugin it belongs to, so the settings button on its row in **Modules** opens it. Defaults to the plugin that registers it. |
| `permission` | Who may see and change it. Defaults to `settings.manage`. |
| `section` | `site` (the default), or `system` for settings about running the installation rather than the site. Those are listed under **Administration**, with users, roles and modules. |
| `order` | Its place in its section. Defaults to 50. |

### A field with its own control

A field can name another admin `component` than its type's. Core stores the default sidebar in a `json` field drawn by its own component, which opens **Customize Sidebar**:

```php
['handle' => 'sidebar', 'type' => 'json', 'label' => 'Sidebar', 'component' => 'sidebar-default']
```

Register the component with `registry.fields` in your [admin module](/plugins/admin-extensions).

## Read a value

```php
$this->cms()->settings('reviews', 'min_rating', 1);
$this->settings('min_rating'); // inside the plugin's provider, for its own settings
```

`$this->settings()` reads the namespace named after your plugin (its `extra.cms.namespace`, or the part of its package name after the slash).

## Where values live

- Normal fields are saved to `config/reviews.yaml`. Commit it to share settings between environments.
- Fields with `secret: true` are encrypted with the app key into `storage/secrets.json`. The admin shows them masked; saving the mask keeps the value.
- Any value can be overridden by the environment: `CMS_REVIEWS_API_KEY=…`. Handy for production secrets. Overrides are never written back when someone saves.

Values are read in that order: defaults, then `config/<namespace>.yaml`, then secrets, then the environment.

## Add to other settings

A plugin can add fields to any namespace, or take over one it manages better elsewhere, with the `settings.fields` filter. The languages plugin removes the site's *Language* field, because languages, the default among them, live under **Languages**:

```php
$this->cms()->hooks()->addFilter('settings.fields', fn (array $fields, string $namespace) => $namespace === 'site'
    ? array_filter($fields, fn ($f) => $f['handle'] !== 'locale')
    : $fields);
```

Core's own settings are namespaces like yours: **Site** (`config/site.yaml`: name, URL, description, timezone, language), **Admin** (`config/admin.yaml`: the language, and the default sidebar and home screen) and **Roles** (`config/roles.yaml`, drawn by a permissions editor).

## Check values together

Field rules check one value at a time. For rules across fields, or to tidy values before they are stored, use the `settings.saving` filter. Throw an `AbilityException` to refuse:

```php
$this->cms()->hooks()->addFilter('settings.saving', function (array $values, string $namespace) {
    if ($namespace === 'reviews' && $values['moderation'] === false && $values['min_rating'] > 1) {
        throw \Cms\Abilities\AbilityException::invalid('Without moderation, show every rating.', ['min_rating' => 'Set this to 1 or turn on moderation.']);
    }

    return $values;
});
```

## For scripts and agents

Settings are abilities (`settings/list`, `settings/get`, `settings/update`), so scripts and agents can read and change them with the right permission. Secrets are never returned.
