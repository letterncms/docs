---
id: 01m5wnc9yk953jb0ypst9kxxwz
title: Settings
position: 3
description: List a few fields, and your plugin gets a settings screen, an API, environment overrides and encrypted secrets.
---
Most plugins need a few options: an API key, a limit, a switch. In Lettern you list the fields, and the rest comes for free: a page under **Settings**, the save bar, validation, abilities for scripts and agents, and safe storage for secrets.

## Add a settings page

Register the fields in your provider's `boot()`:

```php
$this->cms()->settingsRegistry()->register('reviews', fields: [
    ['handle' => 'moderation', 'type' => 'toggle', 'label' => __('Hold new reviews for approval'), 'default' => true],
    ['handle' => 'min_rating', 'type' => 'number', 'label' => __('Hide reviews below'), 'default' => 1, 'min' => 1, 'max' => 5],
    ['handle' => 'api_key', 'type' => 'text', 'label' => __('Trustpilot API key'), 'secret' => true],
], icon: 'star', description: 'How reviews are collected and shown.', permission: 'reviews.manage');
```

That's all it takes for **Reviews** to appear under **Plugins** in the settings sidebar. The page is called what the plugin is, `extra.cms.label` in its `composer.json`, unless you pass a label. People change the fields and save from the save bar that rises while something changed, with **Discard** and **Save** (`⌘S`).

![The SEO plugin's settings page: a form drawn from the fields the plugin registered.](/media/screens/plugins-settings.webp "The SEO plugin's settings are a list of fields like this one.")

Fields use the same format as everywhere else in Lettern, including `if` conditions, `width` and `dynamic` options. See [Field types](/reference/field-types).

### Options

| Argument | Meaning |
|---|---|
| `$namespace` | The settings' name: `reviews` is saved to `config/reviews.yaml`. |
| `$label` | The page's title in the settings sidebar. Leave it out: it defaults to the plugin's name. |
| `$fields` | The fields. |
| `icon`, `description` | How the page is shown. |
| `package` | The plugin it belongs to, so its row in **Plugins** opens it. Defaults to the plugin that registers it. |
| `permission` | Who may see and change it. Defaults to `settings.manage`. |
| `section` | `plugins` (the default). A plugin's page is always listed under **Plugins**, by the plugin's name, whatever section it names; `site`, `people` and `system` are for the core's own modules. |
| `home` | The sidebar item of a screen of the plugin's own, to show the settings as that screen's **Settings** tab instead: see [below](#a-settings-tab-on-your-own-screen). |
| `page` | `false` for values that are set where they're used, with no page of their own. |
| `order` | Its place in its section, for the core's sections. Plugins are listed by name. Defaults to 50. |

### A field with its own control

A field can name another admin `component` than its type's. The **Roles** page is one `json` field drawn by the permissions editor:

```php
['handle' => 'roles', 'type' => 'json', 'label' => '', 'component' => 'roles']
```

Register the component with `registry.fields` in your [admin module](/plugins/admin-extensions).

### A settings tab on your own screen

A plugin with a screen of its own keeps its settings there, as the screen's last tab, **Settings**, drawn by the same form and save bar as every settings page. Forms, Analytics and Commerce work this way, and so does the Media module. Register the settings with `home` set to the screen's sidebar item:

```php
$this->cms()->admin()->nav('reviews', ['path' => '/reviews', 'icon' => 'star']);
$this->cms()->settingsRegistry()->register('reviews', fields: [/* … */], home: 'reviews');
```

Then draw the screen's tabs with `ScreenTabs` from `@letterncms/ui`. It adds **Settings** after the screen's own tabs:

```typescript
const [tab, setTab] = useScreenTabs(['list'])

<ScreenTabs value={tab} onChange={setTab} tabs={[{ value: 'list', label: t('Reviews') }]}>
  {/* what the Reviews tab shows */}
</ScreenTabs>
```

`/settings/reviews` leads to the tab, and the settings are listed under **Plugins** in the settings sidebar too, where they open with only the form.

### Tabs and actions

A settings page is a [view](/plugins/views), `settings`, with its form as the first tab, **Settings**. Add a tab or a button in its bar as data, with the `view.settings` filter and `SettingsModule::withTab()` or `withAction()`. SEO's **Redirects** is a tab like this:

```php
use Cms\Modules\Settings\SettingsModule;
use Cms\Users\User;

$this->cms()->hooks()->addFilter('view.settings', fn (array $view, User $user, array $params) => $params['namespace'] !== 'reviews' ? $view
    : SettingsModule::withTab(SettingsModule::withAction($view, ['label' => __('Import'), 'icon' => 'upload', 'ability' => 'reviews/import'], tab: 'flagged'), [
        'type' => 'ui/tab', 'props' => ['id' => 'flagged', 'label' => __('Flagged')], 'children' => [
            ['type' => 'ui/records', 'props' => ['label' => __('Flagged'), 'source' => ['ability' => 'reviews/flagged'], 'columns' => [['key' => 'title', 'label' => __('Title')]]]],
        ],
    ]));
```

A button shows while its tab is on view: the form's, `settings`, unless you name another. A page with only its form shows no tabs. A tab with unsaved changes is marked, and each form has its own save bar.

### Link to one field

`?field=<handle>` opens a settings page, or a screen's Settings tab, at one field, with the cursor in it: `/settings/reviews?field=api_key`. Commerce's **Go Live** checks lead to what they need this way.

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

A plugin can add fields to any namespace, or take over one it manages better elsewhere, with the `settings.fields` filter. The Languages module removes the site's *Language* field, because languages, the default among them, live under **Languages**:

```php
$this->cms()->hooks()->addFilter('settings.fields', fn (array $fields, string $namespace) => $namespace === 'site'
    ? array_filter($fields, fn ($f) => $f['handle'] !== 'locale')
    : $fields);
```

Core's own settings are namespaces like yours: **General** (`config/site.yaml`: name, URL, description, timezone, language and **Admin Language**, `admin_language`), **Email** (`config/email.yaml`), **Media** (`config/media.yaml`) and **Roles** (`config/roles.yaml`, drawn by a permissions editor). The default sidebar and Dashboard are values of the `admin` namespace (`config/admin.yaml`) with no page of their own: **Save as Default** writes them where they are arranged. Register a namespace with `page: false` for values like these.

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
