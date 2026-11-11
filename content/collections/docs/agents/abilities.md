---
id: 01m5wn8r95ayejch1qyad313h4
title: Abilities
position: 2
description: Every action in Lettern, from saving a page to publishing it, is a named ability. People, AI and scripts all use the same ones.
---
An **ability** is one thing Lettern can do, with a name: `entries/create` creates an entry, `entries/publish` publishes it, `media/import` adds a file. When you press **Publish** in the admin, the admin runs an ability. So does the assistant when you ask it to, and so do your AI tools, the API and the command line.

That's what makes Lettern safe to automate. Because there is one set of actions, there is one set of rules:

- **The same checks.** What goes in is checked before anything happens, and a mistake comes back with what to fix.
- **The same permissions.** An AI tool or a script can only do what the person behind it is allowed to.
- **The same record.** Every change is written to the audit log: who, how and when.

![The audit log: changes made in the admin, by the assistant and over MCP, side by side.](/media/screens/audit.webp)

See it under **Settings → Audit Log**, where you can narrow it to one person or one action. Its **Settings** tab sets what is recorded and for how long.

Every ability on your site is listed in the [abilities reference](/reference/abilities), with what it takes and who may run it. Plugins add their own.

## For developers

### Register an ability

```php
$this->cms()->abilities()->register('shop/price-update', [
    'label' => 'Update a price',
    'description' => 'Set the price of a product, in cents.',
    'permission' => 'shop.prices',
    'input' => [
        'type' => 'object',
        'properties' => [
            'id' => ['type' => 'string'],
            'cents' => ['type' => 'integer', 'minimum' => 0],
        ],
        'required' => ['id', 'cents'],
    ],
    'annotations' => ['idempotent' => true],
    'handler' => fn (array $input, AbilityContext $context) => Product::setPrice($input['id'], $input['cents']),
]);
```

| Key | Meaning |
|---|---|
| name | `thing/verb`, lowercase. A verb means the same on every thing: `list`, `get`, `get-many`, `create`, `update`, `delete`, and `save` for a definition kept by its handle. |
| `label`, `description` | Shown to people and to models, so write them for both. |
| `input` | A JSON schema. Input is validated, and defaults applied, before the handler runs. Errors come back per field. |
| `output` | A JSON schema of what the handler returns, or its short form with `Cms\Support\Schema\Shape`: `Shape::of(['id' => Shape::STRING, 'cents' => Shape::INTEGER])`. Agents and the REST API are told it. |
| `permission` | A permission string, or a closure `fn (?User $user, array $input, AbilityContext $context): bool` for checks that depend on the input. |
| `annotations` | `readOnly`, `destructive`, `confirm`, `idempotent`: used for the audit log, REST verbs, MCP hints and the assistant's approval rules. `trustedOutput` marks a read whose result holds no text people could have written (catalogs, static data); any other result makes the assistant ask before every later change in that chat. `draft` marks a change that stays a draft unless the call publishes or schedules it, which the assistant may still make on its own after reading such text. `openWorld` marks a read that reaches outside the site, which the assistant asks about after reading such text. `confirm` marks a change agents always ask a person about, like a destructive one, such as turning a plugin on or off. |
| `expose` | Turn a transport off: `['mcp' => false]`, `['rest' => false]`, `['assistant' => false]`, `['cli' => false]`. `Ability::ADMIN_ONLY` turns off all four: only the admin runs it, as the person signed in. |
| `dryRun` | A closure `fn (array $input, AbilityContext $context): array` that refuses what the handler would refuse, writes nothing, and returns what running it would change: a list of `['action' => 'delete', 'type' => 'product', …]`. Give one to every `destructive` or `confirm` ability. Without it, a call with `dryRun: true` checks the input and the permission only. |
| `handler` | A closure, an invokable class or `Class@method`. Return anything JSON-serializable. |

### Names

An ability is named `thing/verb`, and a verb means the same on every thing:

| Verb | Does |
|---|---|
| `list` | Several of the thing, filtered and paged |
| `get` | One, by its id or handle |
| `get-many` | Several by id, in the order asked |
| `create` | Makes a new one |
| `update` | Changes one that exists, and answers `not_found` for one that doesn't |
| `delete` | Removes one |
| `save` | Creates or replaces a definition by its handle (`collections/save`, `fieldsets/save`, `globals/save`, `components/save`, `user-fields/save`), or a script or stylesheet of the design by its path (`design-code/save`). Nothing else |

Every other verb is an act of its own, such as `entries/publish`, `media/import` or `languages/set-default`.

Version 0.22 renamed the abilities that didn't follow this, without aliases. A script, a token scope or a plugin that names an old one needs the new name:

| Was | Is |
|---|---|
| `navigation/save` | `navigation/update` for a menu that exists, `navigation/create` to make one |
| `navigation/add` | `navigation/add-item` |
| `languages/save`, `languages/add`, `languages/remove` | `languages/update`, `languages/create`, `languages/delete` |
| `languages/default`, `languages/prefix` | `languages/set-default`, `languages/set-prefix` |
| `entries/lookup`, `media/lookup` | `entries/get-many`, `media/get-many` |
| `users/lookup` | `people/list` |
| `entries/revisions`, `entries/revision`, `entries/restore` | `revisions/list` (the entry is `entryId`), `revisions/get`, `revisions/restore` |
| `globals/update` | `globals/set` |
| `users/fields`, `users/fields-save` | `user-fields/get`, `user-fields/save` |
| `patterns/list`, `patterns/save` | `components/list`, `components/save` |
| `pages/customise` | `pages/customize` |
| `packages/sync` | `packages/migrate` |
| `packages/stores`, `packages/store-add`, `packages/store-remove` | `package-stores/list`, `package-stores/create`, `package-stores/delete` |
| `assistant/resources`, `assistant/resource` | `assistant-resources/list`, `assistant-resources/get` |
| `tokens/revoke` | `tokens/delete` |
| `license/clear` | `license/delete` |
| `design/code` | `design-code/set-custom` |
| `site/get` | `settings/get` with `namespace: site` |

Version 0.23 brought the plugins under the same rule, and gave every plugin ability an `output` schema. Again the old names are gone:

| Plugin | Was | Is |
|---|---|---|
| Forms 0.13 | `forms/activity` | `forms/overview` |
| | `forms/configure` | `form-settings/update` |
| | `forms/words`, `forms/translate` | `form-words/get`, `form-words/update` |
| | `forms/submissions`, `forms/submission`, `forms/submission-update`, `forms/submission-delete`, `forms/export` | `form-submissions/list`, `get`, `update`, `delete` and `csv`. `form-submissions/get` only reads: it no longer marks a new submission read |
| SEO 0.9 | `redirects/save` | `redirects/set`, which puts the whole list in place. `redirects/create` adds one redirect |

Analytics 0.8 and Brevo 0.6 keep their names (`analytics/summary`, `analytics/breakdown`, `brevo/stats`, `brevo/lists`, `brevo/subscribe`) and now say what they answer with.

A token scoped by pattern follows the names: a token for `forms/*` no longer reaches submissions, which are `form-submissions/*`. In the core, `entries/*` doesn't reach `revisions/*`, `users/*` doesn't reach `user-fields/*` or `people/list`, `packages/*` doesn't reach `package-stores/*`, and `design/*` doesn't reach `design-code/*` or `design-vendor/*`.

### Run an ability

From PHP:

```php
$result = cms()->abilities()->execute('entries/publish', ['id' => $id], AbilityContext::forUser($user, 'internal'));
```

From the admin's JavaScript:

```javascript
import { run } from '@letterncms/sdk'

const entry = await run('entries/get', { id })
```

### What every call gets

- **Validation** against the input schema.
- **A dry run**: with `dryRun: true` in the input of an ability that changes something, everything up to the handler happens and nothing more. Nothing is written or logged, and the answer is `{dryRun, ability, checked, input, changes}`. See [Dry runs](#dry-runs).
- **An answer in a known shape**: every ability has an `output` schema beside its `input`, in `abilities/list`, `GET /api/v1/abilities`, `cms run --list --json` and as each MCP tool's `outputSchema`. A map is a JSON object on every transport, also when empty: an entry without field values has `"data": {}`, and a block without settings has `"props": {}`, at any depth. A typed client never gets `[]` where it expects an object.
- **Authorization**: the user's permissions and, for tokens, the token's scopes.
- **Audit**: every change (anything not read-only) is logged with who, how and when.
- **Hooks**: `ability.input` can adjust the input, `ability.executing` and `ability.executed` fire around the call, and `ability.result` can adjust the result.
- **Errors** in one shape, `{ "type": "invalid_input", "message": "…", "details": { "field": "…" } }`, with the types `invalid_input`, `forbidden`, `unauthenticated`, `not_found`, `conflict` and `failed`.

### Dry runs

A dry run answers one question before anything changes: would this call go through, and what would it do?

```bash
php cms run entries/delete id=01m75ewmnmrmh0d80z43axs3k5 --dry-run
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "entries/delete",
        "checked": "full",
        "input": { "id": "01m75ewmnmrmh0d80z43axs3k5" },
        "changes": [
            {
                "action": "delete",
                "type": "entry",
                "id": "01m75ewmnmrmh0d80z43axs3k5",
                "collection": "pages",
                "title": "About",
                "uri": "/about",
                "live": true,
                "revisions": 1,
                "childrenMovedUp": 0
            }
        ]
    }
}
```

`checked` says how far the check went:

| `checked` | Means |
|---|---|
| `"full"` | The dry run is refused exactly where the real run would be, by the same code, and `changes` lists what would change or be removed |
| `"input"` | Only the input and your permission were checked. `changes` is `null`, and the real run may still refuse |

Checked in full: entries (create, update, publish, unpublish, discard, delete, duplicate, move, reorder, restore, and `pages/customize`), `settings/update`, and every ability marked destructive or that asks first: deleting a collection, a file, a user, a global set, a menu, a comment, a chat or a token, removing a language, switching or uninstalling a plugin, starting or undoing a sync. Anything else is checked as input, like this import, which would have to fetch the file to know more:

```bash
php cms run media/import url=https://example.com/a.png --dry-run
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "media/import",
        "checked": "input",
        "input": { "url": "https://example.com/a.png", "folder": "" },
        "changes": null
    }
}
```

`input` is the input as the ability would get it, with its defaults filled in. A refused dry run is the same error the real run would give, with a field named by its path in the input:

```json
{
    "error": {
        "type": "invalid_input",
        "message": "Invalid input: data.template: Must be one of: \"default\", \"page\", \"post\", null.",
        "details": {
            "data.template": "Must be one of: \"default\", \"page\", \"post\", null."
        }
    }
}
```

In the workspace and for the assistant, a dry run shows as a check, not as a change. [Build a page with an agent](/agents/build-a-page) uses them from start to finish.

