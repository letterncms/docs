---
id: nejyvjrhjyakfcmmc6w0fez03n
title: Views
position: 5
description: Ship a screen of the admin as data. Lists, forms, tabs and actions bound to your abilities, drawn by Lettern like every place of the admin.
---
Every place of the admin is a view: a tree of components, written as data. A list binds to the ability that lists your records, a form to the ability that loads it and the one that saves it, and a button to the ability it runs. Lettern draws every view with the same renderer, so your plugin's screens look and behave like the rest of the admin, in light and dark, on a phone and in every language. You write no React for them.

## Register a view

A view has an id, a path in the admin, and its tree. Register it in your provider's `boot()`:

```php
use Cms\Users\User;

$this->cms()->views()->register('reviews', '/reviews', fn (User $user) => [
    'type' => 'ui/page',
    'props' => ['title' => __('Reviews'), 'icon' => 'star', 'actions' => [
        ['label' => __('New Review'), 'icon' => 'plus', 'variant' => 'primary', 'ability' => 'reviews/create',
            'form' => ['title' => __('New Review'), 'fields' => [['handle' => 'title', 'type' => 'text', 'label' => __('Title'), 'required' => true]]]],
    ]],
    'children' => [
        ['type' => 'ui/records', 'props' => [
            'label' => __('Reviews'),
            'source' => ['ability' => 'reviews/list'],
            'columns' => [
                ['key' => 'title', 'label' => __('Title')],
                ['key' => 'rating', 'label' => __('Rating'), 'format' => 'number', 'align' => 'end'],
                ['key' => 'status', 'label' => __('Status'), 'format' => 'badge', 'tones' => ['published' => 'success']],
                ['key' => 'updatedAt', 'label' => __('Updated'), 'format' => 'ago'],
            ],
            'open' => ['label' => __('Open'), 'to' => '/reviews/{row.id}'],
            'actions' => [['label' => __('Delete'), 'variant' => 'danger', 'ability' => 'reviews/delete', 'input' => ['id' => '{row.id}'], 'confirm' => ['title' => __('Delete {row.title}?')]]],
            'empty' => ['icon' => 'star', 'title' => __('No reviews yet')],
        ]],
    ],
], permission: 'reviews.view');

$this->cms()->admin()->nav('reviews', ['path' => '/reviews', 'icon' => 'star']);
```

The closure gets the user and the route's params (`/reviews/:id` gives `$params['id']`). Pass `private: true` for a place whose contents stay out of what an agent is told about the screen on view.

Or ship the same tree as a file, `views/reviews.json`, with `{"path": "/reviews", "permission": "reviews.view", "view": {…}}`, and call `$this->views()` in `boot()`.

Write the words of a view in English, with `__()` as anywhere in PHP: `'label' => __('Rating')`. Each person reads them in their language, from your package's `lang/` files. A value from your records, such as a review's title or a field someone named, stays as it was written, so leave it bare. A view shipped as a file is all words, and Lettern translates it for you. `./dev check` reports a word in a PHP view left without `__()`.

## What Lettern checks

Before a view reaches the admin, Lettern:

- checks every node against the component catalog and its props, and refuses an unknown component or a misspelled prop;
- leaves out every node with `can` (a permission, or a list of them) that the person doesn't hold;
- leaves out every action whose ability the person may not run, so no button that would only fail is shown;
- puts every label in the person's language.

Every list, form and button runs its ability as the person looking. Agents don't use views. They run the same abilities directly, over MCP or the API.

## Templates

A string in a view can hold `{params.x}` (the route), `{query.x}` (the address), `{user.x}` (who is signed in) and `{row.x}` (the row an action or dialog belongs to). A string that is nothing but one reference stands for the value itself, such as an object or a list. Write `{{word}}` for the words `{word}` themselves. Ability input left empty after filling in is not sent, so an unchosen filter doesn't narrow anything.

## Components

| Component | What it draws |
|---|---|
| `ui/page` | The bar that names the place (`title`, `icon`), how many it holds (`count`, from an ability), the list it belongs to (`back`), its `actions`, and `width` (`narrow`, `default`, `wide`, `full`). |
| `ui/tabs`, `ui/tab` | A page's tabs, each with an `id`, a `label`, a `count` and `actions` of its own. A plugin that keeps its settings with this place gets its Settings tab after them. With `display: "segmented"` they are one control that switches the same thing in another version, such as a language, named by the tabs' `label`; each tab's `label` is short (`EN`) and its `title` says it in full on hover (`English`). |
| `ui/section` | A titled group, with `actions`. |
| `ui/stack`, `ui/grid` | One after another, or side by side in `columns`. |
| `ui/records` | Records from an ability: a table, cards or a calendar, with search, filters, sorting, pages, a tree, a row that opens, row actions and bulk actions. Every list in the admin is one, a collection's entries too. |
| `ui/form` | Fields loaded from one ability and saved with another, with the save bar. |
| `ui/settings` | A settings page's form, by `namespace`. |
| `ui/detail` | Labelled values (`items`), or every value of a `record`, with its `raw` data to unfold. |
| `ui/stat`, `ui/chart` | A metric with its trend, a line or bar chart: literal, or from a `source`. |
| `ui/notice` | A line that needs attention, with one `action`. |
| `ui/diff` | Before and after, key by key. |
| `ui/preview` | A page of the site, at `url`. |
| `ui/actions` | A row of buttons. |
| `ui/links` | A short list of places, each a line with its `icon`, `label` and `detail`, that opens at `to`. |
| `ui/text`, `ui/empty` | Words, or nothing there yet, with one `action`. |
| `ui/redirect` | Sends whoever opens the place to where it is now. |
| `widget/<id>` | A Dashboard widget. |

Your own components are in the catalog too (see [Generative UI](/plugins/generative-ui)). Use one in a view for what the catalog doesn't draw, such as an editor, and keep the place around it as data.

### `ui/records`

```php
['type' => 'ui/records', 'props' => [
    'label' => __('Orders'),
    'source' => ['ability' => 'orders/list', 'input' => ['status' => '{query.status}']],
    'at' => 'items',            // where the rows are in the response (`0.pages` in a list); without it, a list is the rows itself
    'key' => 'id',              // what tells the rows apart
    'columns' => [['key' => 'customer.name', 'label' => __('Customer'), 'muted' => 'customer.email']],
    'search' => ['param' => 'search', 'placeholder' => __('Search orders…')],
    'filters' => [['param' => 'status', 'label' => __('Status'), 'all' => __('All Orders'), 'options' => [['value' => 'paid', 'label' => __('Paid')]]]],
    'address' => true,          // search, filters and page in the address: linkable, and kept on Back
    'paged' => ['perPage' => 50],
    'open' => ['label' => __('Open'), 'to' => '/orders/{row.id}'],
    'sort' => ['param' => 'sort', 'default' => '-created_at'],
    'actions' => [],
    'bulk' => [['label' => __('Archive'), 'ability' => 'orders/archive', 'input' => ['ids' => '{ids}']]],
    'empty' => ['icon' => 'receipt', 'title' => __('No orders yet')],
]]
```

- **Search:** with a `param`, the ability searches. Without one, a list loaded whole is searched in the browser. `search: false` offers none, and `display: false` makes it a list read as it is (a ranked top 8): no Display menu or sorting.
- **Filters:** a filter's options are listed, or come from the response: `at` is where they are, `value` and `text` name their keys. `display: "segmented"` shows every choice at once, one always on, with `default` standing for none (`All`).
- **Pages:** `paged` sends `page` and `perPage`, and reads `pages` or `total` from the response.
- **Sorting:** with `sort`, the ability sorts: its `param` gets a column's `sort` name, `-` first for descending, and `default` is the order while nobody picked one. Without it, a column with `sort: true` sorts what is loaded. Each person's sort, columns and view are kept with their account.
- **Tree:** `tree` draws records that hold others nested, while nothing narrows or sorts the list: its `source` loads them (each with its `children`), and `reorder` is an action that puts siblings in the order they were dragged into, with `{ids}`, `{parent}` and `{versions}` (from each row's `version`).
- **Cards and calendar:** a column with `image: true` offers cards, and one with `excerpt: true` is a few lines on them; `card: true` shows a column on cards from the start. `calendar` offers a calendar; as `{"dated": …, "undated": …}` it loads a month at a time, with the ability's input filled in with `{field}`, `{start}` and `{end}`. `dates` names what the ability sorts the published and updated dates by. `defaultView` is the view a person sees until they pick one.
- **Bulk actions:** they make the rows selectable, and each one gets the selected rows' `{ids}`. With `each: true` it runs once per row, with `{row}`, and what failed stays selected with the reason; `some` shows it only while it holds for one of them. Its `success` and its `confirm` title can say how many: `{"one": "Deleted {count} entry", "other": "Deleted {count} entries"}`.
- **Empty:** `empty` with an `icon`, a `title`, a `text` and an `action`, or `size: "sm"` for one quiet line inside a section.
- **Literal rows:** `rows` in place of `source` lists records as they are, such as what a command found when the [workspace](/getting-started/workspace) answers with it.

A column's `format` writes its value: `text`, `strong`, `muted`, `code`, `address` (a path of the site), `badge` and `badges`, `status` (a dot and a word), `date`, `datetime`, `ago`, `number`, `money` (in cents, with `currency`), `bytes`, `share` (a bar for a part of the whole, 0 to 1), `compact` (1.2K), `yesno`, `person`, `count`, `image`, `media` (thumbnails of files, looked up), `languages` (which of the `locales` a record has), `field` (as a blueprint `field` of that `type` reads) and `link`. `tones` and `labels` give a value its color and its words.

More of a column:

- `muted` names a second value drawn quieter after the first, cut short before the first is; `mutedWhole: true` keeps it whole and cuts the first short instead (who is editing, beside a title). `warning` names a problem drawn in its place.
- `icon` names the row's own icon, and `empty` what an empty value reads as.
- `hidden: true` keeps a column in Display until someone shows it, and `fit: true` makes it as wide as its longest value.
- `image: true` gives the list a grid of cards.
- `format: switch` with an `action` draws a switch that runs the action with `{row}` and the new `{value}`. `ariaLabel` names it for each row, `disabled` names a key of the row that locks it, and `reason` one that says why, on hover or a press of a lock before the switch.

### `ui/form`

```php
['type' => 'ui/form', 'props' => [
    'source' => ['ability' => 'reviews/settings'],   // returns {fields, values}; or give `fields` here
    'save' => ['ability' => 'reviews/configure', 'as' => 'values'],
    'after' => 'manifest',
]]
```

The values are saved under `as` (`values` unless you name another key), or spread over the input with `as: "*"`. Use `into` for a list edited whole as one field, such as a repeater with `display: table`. `context` tells the fields where they are, such as `{"locale": "fr"}`. `?field=<handle>` opens the form at one of its fields.

Two options of a form's fields:

- `confirmChange: {from, title, text, confirm}` asks before a change that loses something is saved: when the field was `from` and is now something else, a dialog with `title`, `text` and a red `confirm` button comes first, and nothing is saved without it.
- `removeLabel` names a table's row button (a `repeater` with `display: table`): **Remove** for a row that is part of the value, `__('Delete')` for one that is a record of its own, such as a redirect.

A component of yours in a tab marks the tab while it has unsaved changes with `useTabDirty(dirty)` from `@letterncms/ui`, as a form there does.

## Actions

Buttons, row actions, a row that opens, and a notice's action all take the same shape:

| Key | What it does |
|---|---|
| `ability`, `input` | Runs the ability. `success` is said once it worked. `then` is `refresh`, `manifest`, `back`, `open` (opens `to` with `{result}`) or `download` (saves a result of `{name, type, content}` as a file, with `encoding: "base64"` for one that isn't text, such as a zip), or a list of them. |
| `form` | Asks first: `fields` in a dialog. Without `input`, their values are the input; with one, write them in as `{values.x}`. A refusal shows on its fields, and the dialog stays open. |
| `copy` | Copies a template to the clipboard. |
| `confirm` | Asks first: `title`, `text`, `confirm`, `danger`. |
| `variant` | How its button looks: `default`, `primary`, `ghost`, `destructive` (red words, the way into deleting something, which asks first with a red button) or `danger` (a red button). |
| `to`, `href` | Goes to a place of the admin, or opens a link in a new tab. |
| `dialog` | Opens a dialog of nodes (`title`, `text`, `body`, `actions`), drawn with the row it was opened for. |
| `component` | Opens one of your catalog components with `props`. It gets `close` and `scope`. |
| `when`, `unless`, `can` | Shows the action only when a template holds or doesn't, or for a permission. A template can compare too: `{row.status} is draft, changed`, `{row.status} is not published`. |
| `inline` | A row's action with an `icon` as a button beside its menu. |
| `key` | A page's action on a key as well: `c`. |
| `disabled` | Shows it, but not possible while a template holds. In a page's bar, `{dirty}` holds while the tab on view has unsaved changes. |
| `name` | Opens it from the address too: `/reviews?do=new-review`. |

After an ability runs, everything on view loads again.

## Add to another view

Every view passes through the `view.<id>` filter, with the user and the params. Settings pages are the view `settings` with `['namespace' => …]`, and `SettingsModule::withTab()` and `withAction()` add to one:

```php
use Cms\Modules\Settings\SettingsModule;

$this->cms()->hooks()->addFilter('view.settings', fn (array $view, User $user, array $params) => $params['namespace'] !== 'reviews' ? $view
    : SettingsModule::withAction($view, ['label' => __('Send Test'), 'icon' => 'mail', 'ability' => 'reviews/test', 'input' => ['to' => '{user.email}'], 'success' => __('Sent to {user.email}')]));
```

The `views/get` ability returns a view as the admin draws it, for the person signed in.

## Answers in the workspace

The [workspace](/getting-started/workspace) answers a command with a view too: the ability's own `answer`, or one drawn from what it returned. It's checked like any view, kept with the thread, and its buttons run as commands of the thread. See [Answers](/getting-started/workspace#answers).
