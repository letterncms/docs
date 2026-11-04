---
id: 01kbkrfxg19qfztswcf4g8geka
title: Generative UI
position: 6
description: Let the assistant answer with your plugin's widgets and components, not just text.
---
When someone asks the assistant a question, it can answer with an interface instead of text: a live widget, a summary card, a table, a button that publishes a page. It builds these from the widgets and components your plugin already has, so the answer looks and works like the rest of the admin.

Under the hood, Lettern uses [json-render](https://json-render.dev/): the model writes a small declarative spec, and your installed React components draw it.

## Your widgets already work

A widget registered with `$admin->widget('reviews', ...)` and `registry.widgets.set('reviews', ReviewsWidget)` is available to the assistant as `widget/reviews`. There's nothing assistant-specific to write. Its permission, label, queries, loading states and controls stay with the existing component, and the Dashboard and the chat both render it through the same `WidgetSlot`.

Set `'assistant' => false` in the PHP widget registration if the widget should only appear on the Dashboard, for example an assistant launcher.

## Add a component the assistant can fill in

A widget shows what it always shows. Use a **component** when the assistant should choose what it shows, such as one record or a comparison.

First, describe its props in your provider's `boot()`:

```php
$this->cms()->admin()->component('reviews/summary', [
    'label' => 'Review summary',
    'description' => 'A compact review summary for a selected product.',
    'permission' => 'reviews.view',
    'props' => [
        'type' => 'object',
        'properties' => [
            'product' => ['type' => 'string', 'maxLength' => 160],
            'rating' => ['type' => 'number', 'minimum' => 0, 'maximum' => 5],
        ],
        'required' => ['product', 'rating'],
        'additionalProperties' => false,
    ],
]);
```

Then register the implementation in the same admin module as your screens and widgets:

```typescript
import { registry, t, type SurfaceComponentProps } from '@letterncms/sdk'
import { Stat } from '@letterncms/ui'

function ReviewSummary({ props }: SurfaceComponentProps<{ product: string; rating: number }>) {
  return <Stat label={props.product} value={t('{rating} / 5', { rating: props.rating })} />
}

registry.components.set('reviews/summary', ReviewSummary)
```

Lettern includes the schema in the catalog the assistant sees, filtered by permission. The component disappears and returns with its module when its plugin is turned off and on again.

| Key | Meaning |
|---|---|
| `label`, `description` | What the assistant reads to decide when to use it. |
| `props` | A JSON Schema for its props. |
| `permission` | Who it's offered to. |
| `children` | `true` for a container: the React component receives the rendered `children`. |

Component ids are namespaced, like `reviews/summary`. `ui/` and `widget/` belong to Lettern.

## How the assistant composes

The assistant discovers prop schemas with `ui_catalog`, then calls `ui_present` with a versioned envelope around a native json-render spec:

```json
{
  "version": 1,
  "id": "review-overview",
  "title": "Product reviews",
  "spec": {
    "root": "layout",
    "elements": {
      "layout": { "type": "ui/stack", "props": {}, "children": ["summary", "live"] },
      "summary": { "type": "reviews/summary", "props": { "product": "Example", "rating": 4.5 } },
      "live": { "type": "widget/reviews", "props": {} }
    }
  }
}
```

The built-in types are `ui/stack`, `ui/grid`, `ui/text`, `ui/stat`, `ui/table` and `ui/action`. `ui/stat` uses the shared metric and trend primitives; `ui/table` uses the shared data table. Grids adapt to their container. Reusing a surface id replaces its previous accepted presentation.

## Buttons that do something

An action button emits `submit`. Bind it to an existing ability with json-render's own `on` shape:

```json
{
  "type": "ui/action",
  "props": { "label": "Publish this page" },
  "on": {
    "submit": { "action": "entries/publish", "params": { "id": "ENTRY_ID" } }
  }
}
```

Your own components receive `onAction(name)` and `disabled`:

```typescript
function Choice({ props, onAction, disabled }: SurfaceComponentProps<{ label: string }>) {
  return <Button disabled={disabled} onClick={() => onAction('choose')}>{props.label}</Button>
}
```

- Emit declared events only from a person's explicit interaction, and respect `disabled`.
- Don't run generated ability names or params with `run()` from your renderer. The host resolves the stored binding on the server and applies the normal permission, approval and audit rules.

An interface action can be selected once. After a selection, approval or decline, the assistant can present a fresh view for the next step. Reloading history doesn't re-enable consumed actions. Existing widget controls keep their normal behavior.

## Render it somewhere else

To show a surface in another admin screen, import `Surface` from `@letterncms/ui` and pass a server-validated `SurfaceDocument`, plus an `onAction` callback. The callback receives only `{ node, name }`; your host associates it with the stored surface. Without a callback, the surface's generated actions are disabled. The json-render runtime loads on demand and is shared by every plugin.

## What version 1 supports

Version 1 supports literal props and single named action bindings. It validates the complete tree before showing it, and supports saved history. Partial JSON rendering, dynamic state expressions, form binding and external iframe apps are outside this version's contract.

Keep all styling, accessibility and live data behavior inside reusable components from your module or the admin UI kit.
