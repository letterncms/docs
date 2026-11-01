---
id: 01kbkrfxg19qfztswcf4g8geka
title: Generative UI
position: 7
group: 'Admin'
description: Let Lettern compose your plugin's widgets and components into contextual interfaces, using json-render and the shared admin SDK.
---
The assistant can compose a contextual interface from your installed widgets and components. Lettern uses [json-render](https://json-render.dev/) to render native React components inside the conversation. The model supplies a declarative spec; your installed code supplies the UI.

## Existing widgets work automatically

A widget registered with `$admin->widget('reviews', ...)` and `registry.widgets.set('reviews', ReviewsWidget)` is available as `widget/reviews`. No assistant-specific integration is required. Its permission, label, queries, loading states and controls stay with the existing component. Home and chat render it through the same `WidgetSlot`.

Set `'assistant' => false` in the PHP widget registration if the widget should only appear on Home, for example an assistant launcher.

## Register a contextual component

Use a component when the assistant should choose the props, such as an individual record or comparison. Register the schema in your plugin's `boot()`:

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

Register the implementation in the same admin module that registers your screens and widgets:

```typescript
import { registry, t, type SurfaceComponentProps } from '@letterncms/sdk'
import { Stat } from '@letterncms/ui'

function ReviewSummary({ props }: SurfaceComponentProps<{ product: string; rating: number }>) {
  return <Stat label={props.product} value={t('{rating} / 5', { rating: props.rating })} />
}

registry.components.set('reviews/summary', ReviewSummary)
```

Lettern includes the schema in the permission-filtered catalog. The component disappears and returns with its module when a package is disabled or re-enabled. Use `children: true` in PHP for containers; the React component receives rendered `children`. Component ids are namespaced; `ui/` and `widget/` belong to Lettern.

## Composition and actions

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

Built-in types are `ui/stack`, `ui/grid`, `ui/text`, `ui/stat`, `ui/table` and `ui/action`. `ui/stat` uses the shared metric and trend primitives; `ui/table` uses the shared data table. Grids adapt to their container. Reusing a surface id replaces its previous accepted presentation.

An action button emits `submit`. Bind an existing ability using native json-render's `on` shape:

```json
{
  "type": "ui/action",
  "props": { "label": "Publish this page" },
  "on": {
    "submit": { "action": "entries/publish", "params": { "id": "ENTRY_ID" } }
  }
}
```

Custom components receive `onAction(name)` and `disabled`. Emit declared events only from a user's explicit interaction and respect `disabled`. Do not execute generated ability names or params with `run()` from your renderer: the host resolves the stored binding on the server and applies the normal permission, approval and audit rules.

```typescript
function Choice({ props, onAction, disabled }: SurfaceComponentProps<{ label: string }>) {
  return <Button disabled={disabled} onClick={() => onAction('choose')}>{props.label}</Button>
}
```

An interface action can be selected once. After a selection, approval or decline, the assistant can present a fresh view for the next step. Reloading history does not re-enable consumed actions. Existing widget controls retain their normal behavior.

## Render in another admin surface

Import `Surface` from `@letterncms/ui` and pass a server-validated `SurfaceDocument`, plus an `onAction` callback. The callback receives only `{ node, name }`; your host associates it with the stored surface. Without a callback the surface's generated actions are disabled. The json-render runtime loads on demand and is shared by every plugin.

Version 1 supports literal props and single named action bindings. It validates the complete tree before displaying it and supports saved history; partial JSON rendering, dynamic state expressions, form binding and external iframe apps are outside this version's contract. Keep all styling, accessibility and live data behavior inside reusable components from your module or the admin UI kit.
