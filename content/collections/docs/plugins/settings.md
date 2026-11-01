---
id: 01m5wnc9yk953jb0ypst9kxxwz
title: Settings
position: 3
group: 'Build'
description: Declare a group of fields and get a settings screen, an API, environment overrides and encrypted secrets.
---
```php
$this->cms()->settingsRegistry()->register('reviews', 'Reviews', [
    ['handle' => 'moderation', 'type' => 'toggle', 'label' => 'Hold new reviews for approval', 'default' => true],
    ['handle' => 'min_rating', 'type' => 'number', 'label' => 'Hide reviews below', 'default' => 1, 'min' => 1, 'max' => 5],
    ['handle' => 'api_key', 'type' => 'text', 'label' => 'Trustpilot API key', 'secret' => true],
], icon: 'star', description: 'How reviews are collected and shown.', package: $this->manifest->name, permission: 'reviews.manage');
```

That is all it takes for **Settings → Reviews** to appear: a page of the settings sidebar, under **Site**. Pass `section: 'system'` for settings about running the installation rather than the site — they are listed under **Administration**, with users, roles and modules — and `order` for its place there. Fields use the same format as everywhere else, including `if` conditions, `width` and `dynamic` options. A field can name another admin `component` than its type's — core stores the default sidebar in a `json` field drawn by its own component, which opens **Customize Sidebar**:

```php
['handle' => 'sidebar', 'type' => 'json', 'label' => 'Sidebar', 'component' => 'sidebar-default']
```

Core uses nothing else: **Site** (`config/site.yaml` — name, URL, description, timezone, language) **Admin** (`config/admin.yaml` — the language and the default sidebar and home screen) and **Roles** (`config/roles.yaml`, drawn by a permissions editor) are settings namespaces like yours.

## Reading values

```php
$this->cms()->settings('reviews', 'min_rating', 1);
$this->settings('min_rating'); // inside the plugin's provider, for its own group
```

## Where values live

- Normal fields are saved to `config/reviews.yaml` — commit it to share settings between environments.
- Fields with `secret: true` are encrypted with the app key into `storage/secrets.json`. The admin shows them masked; saving the mask keeps the value.
- Any value can be overridden by the environment: `CMS_REVIEWS_API_KEY=…`. Handy for production secrets. Overrides are never written back when someone saves.

## Adding to other settings

A plugin can add fields to any namespace, or take one over that it manages better elsewhere, with the `settings.fields` filter. The languages plugin removes the site's *Language* field, because languages — the default among them — live under **Languages**:

```php
$this->cms()->hooks()->addFilter('settings.fields', fn (array $fields, string $namespace) => $namespace === 'site'
    ? array_filter($fields, fn ($f) => $f['handle'] !== 'locale')
    : $fields);
```

## Checking values together

Field rules check one value at a time. For rules across fields, or to tidy values before they are stored, use the `settings.saving` filter — throw an `AbilityException` to refuse:

```php
$this->cms()->hooks()->addFilter('settings.saving', function (array $values, string $namespace) {
    if ($namespace === 'reviews' && $values['moderation'] === false && $values['min_rating'] > 1) {
        throw \Cms\Abilities\AbilityException::invalid('Without moderation, show every rating.', ['min_rating' => 'Set this to 1 or turn on moderation.']);
    }

    return $values;
});
```

Settings are abilities (`settings/list`, `settings/get`, `settings/update`), so scripts and agents can read and change them with the right permission. Secrets are never returned.
