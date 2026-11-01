---
id: 01m5wn8r95ayejch1qyad313h4
title: Abilities
position: 0
group: 'API'
description: An ability is a named action with an input schema, a permission and a handler. Everything in Lettern is built on them.
---
## Anatomy

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
| `label`, `description` | Shown to people and to models — write them for both. |
| `input` | A JSON schema. Input is validated (and defaults applied) before the handler runs; errors come back per field. |
| `permission` | A permission string, or a closure `fn (?User $user, array $input, AbilityContext $context): bool` for checks that depend on the input. |
| `annotations` | `readOnly`, `destructive`, `idempotent` — used for audit, REST verbs, MCP hints and the assistant's approval rules. `trustedOutput` marks a read whose result holds no text people could have written (catalogs, static data); any other result makes the assistant ask before every later change in that chat. |
| `expose` | Turn a transport off: `['mcp' => false]`, `['rest' => false]`, `['assistant' => false]`, `['cli' => false]`. |
| `handler` | A closure, an invokable class or `Class@method`. Return anything JSON-serializable. |

## Running abilities

```php
$result = cms()->abilities()->execute('entries/publish', ['id' => $id], AbilityContext::forUser($user, 'internal'));
```

From the admin's JavaScript:

```javascript
import { run } from '@letterncms/sdk'

const entry = await run('entries/get', { id })
```

## What every call gets

- **Validation** against the input schema.
- **Authorization** — the user's permissions and, for tokens, the token's scopes.
- **Audit** — every change (anything not read-only) is logged with who, how and when; see **Settings → Audit Log**, and **Settings → Auditing** for what is recorded and for how long.
- **Hooks** — `ability.input` can adjust input, `ability.executing` and `ability.executed` fire around the call, `ability.result` can adjust the result.
- **Errors** in one shape: `{ "type": "invalid_input", "message": "…", "details": { "field": "…" } }` with types `invalid_input`, `forbidden`, `unauthenticated`, `not_found`, `conflict` and `failed`.

See every ability on this installation in the [abilities reference](/agents/abilities-reference).
