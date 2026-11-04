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
| name | `namespace/action`, lowercase. |
| `label`, `description` | Shown to people and to models, so write them for both. |
| `input` | A JSON schema. Input is validated, and defaults applied, before the handler runs. Errors come back per field. |
| `permission` | A permission string, or a closure `fn (?User $user, array $input, AbilityContext $context): bool` for checks that depend on the input. |
| `annotations` | `readOnly`, `destructive`, `confirm`, `idempotent`: used for the audit log, REST verbs, MCP hints and the assistant's approval rules. `trustedOutput` marks a read whose result holds no text people could have written (catalogs, static data); any other result makes the assistant ask before every later change in that chat. `draft` marks a change that stays a draft unless the call publishes or schedules it, which the assistant may still make on its own after reading such text. `openWorld` marks a read that reaches outside the site, which the assistant asks about after reading such text. `confirm` marks a change agents always ask a person about, like a destructive one, such as turning a plugin on or off. |
| `expose` | Turn a transport off: `['mcp' => false]`, `['rest' => false]`, `['assistant' => false]`, `['cli' => false]`. |
| `handler` | A closure, an invokable class or `Class@method`. Return anything JSON-serializable. |

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
- **Authorization**: the user's permissions and, for tokens, the token's scopes.
- **Audit**: every change (anything not read-only) is logged with who, how and when.
- **Hooks**: `ability.input` can adjust the input, `ability.executing` and `ability.executed` fire around the call, and `ability.result` can adjust the result.
- **Errors** in one shape, `{ "type": "invalid_input", "message": "…", "details": { "field": "…" } }`, with the types `invalid_input`, `forbidden`, `unauthenticated`, `not_found`, `conflict` and `failed`.
