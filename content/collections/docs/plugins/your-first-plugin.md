---
id: 01m5wn8ra43mwhmr52e5p62qx4
title: Your first plugin
position: 0
group: 'Build'
description: Build a reading-time plugin with a setting, an ability, a value designers can show on pages, a panel in the editor and a home-screen widget — the same pieces Lettern's own plugins use.
---
We will build **Reading time**: it estimates how long an entry takes to read, lets editors see it while writing, lets agents ask for it, lets designers show it on pages and puts the longest reads on the home screen. Everything lives in one folder.

```markdown
plugins/reading-time/
  composer.json
  src/ReadingTimePlugin.php
  src/ReadingTime.php
  admin/src/index.tsx
  package.json
  vite.config.mjs
```

## 1. The package

```json
{
    "name": "acme/reading-time",
    "description": "Estimates reading time for entries.",
    "type": "cms-plugin",
    "version": "1.0.0",
    "require": {
        "letterncms/cms": ">=0.1 <1",
        "letterncms/blocks": ">=0.1 <1"
    },
    "autoload": { "psr-4": { "Acme\\ReadingTime\\": "src/" } },
    "extra": {
        "cms": {
            "label": "Reading time",
            "icon": "clock",
            "provider": "Acme\\ReadingTime\\ReadingTimePlugin"
        }
    }
}
```

`require` names what the plugin needs: the Lettern version (`letterncms/cms`) and other plugins. They are real Composer packages, so `composer require` brings them along, and without Composer Lettern checks the same list.

## 2. The estimate

```php
<?php

namespace Acme\ReadingTime;

use Cms\Blocks\Document;
use Cms\Content\Entries\Entry;

final class ReadingTime
{
    public function __construct(private readonly Document $blocks) {}

    /** @return array{words: int, minutes: int} */
    public function estimate(Entry $entry, int $wordsPerMinute): array
    {
        $text = $entry->working()['title'];

        foreach ($entry->working()['data'] as $value) {
            $text .= ' '.(is_array($value) ? $this->blocks->text($value) : (is_string($value) ? strip_tags($value) : ''));
        }

        $words = preg_match_all("/[\p{L}\p{N}']+/u", $text);

        return ['words' => $words, 'minutes' => max(1, (int) ceil($words / max(1, $wordsPerMinute)))];
    }
}
```

`Document::text()` comes from the blocks plugin — which is why `composer.json` requires it.

## 3. The provider

```php
<?php

namespace Acme\ReadingTime;

use Cms\Abilities\AbilityContext;
use Cms\Packages\Plugin;
use Cms\Users\User;

final class ReadingTimePlugin extends Plugin
{
    public function register(): void
    {
        $this->app->singleton(ReadingTime::class);
    }

    public function boot(): void
    {
        // A settings screen, for free: Settings → Reading time.
        $this->cms()->settingsRegistry()->register('reading-time', 'Reading time', [
            ['handle' => 'words_per_minute', 'type' => 'number', 'label' => 'Words per minute', 'default' => 230, 'min' => 50],
        ], icon: 'clock', package: $this->manifest->name);

        // One ability: the admin, the API, agents and the CLI can all use it.
        $this->cms()->abilities()->register('reading-time/estimate', [
            'label' => 'Estimate reading time',
            'description' => 'How many words an entry has and how many minutes it takes to read.',
            'annotations' => ['readOnly' => true],
            'permission' => function (?User $user, array $input) {
                $entry = $this->cms()->entries()->find($input['id']);

                return $entry && $user?->hasPermission("entries.{$entry->collection}.view");
            },
            'input' => [
                'type' => 'object',
                'properties' => ['id' => ['type' => 'string']],
                'required' => ['id'],
            ],
            'handler' => fn (array $input) => $this->app->make(ReadingTime::class)->estimate(
                $this->cms()->entries()->findOrFail($input['id']),
                (int) $this->cms()->settings('reading-time', 'words_per_minute', 230),
            ),
        ]);

        $this->adminModule(css: null);
    }
}
```

The permission is a closure because it depends on the entry: you may only estimate entries you can see.

## 4. A value designers can use

Templates are designed on the block workspace, so instead of a helper function the plugin adds the estimate to the data pages are rendered with. Add this to `boot()`:

```php
// Templates can show {readingTime.minutes} for the page being rendered.
$this->cms()->hooks()->addFilter('site.scope', fn (array $scope, $page) => $page->entry
    ? [...$scope, 'readingTime' => $this->app->make(ReadingTime::class)->estimate($page->entry, (int) $this->cms()->settings('reading-time', 'words_per_minute', 230))]
    : $scope);
```

Now a designer opens the article template, adds a **Text** block under the title and connects its text to `{readingTime.minutes} min read` — no template code, and the value is right on every page.

## 5. A panel in the editor

Admin modules are small React bundles. React, `@letterncms/sdk` and `@letterncms/ui` come from the admin, so the bundle contains only your code.

```typescript
// admin/src/index.tsx
import { invalidate, plural, registry, t, useAbility, type Entry } from '@letterncms/sdk'
import { useEffect } from 'react'

function ReadingTimePanel({ entry }: { entry: Entry | null }) {
  const estimate = useAbility<{ words: number; minutes: number }>('reading-time/estimate', { id: entry?.id ?? '' }, { enabled: !!entry })

  // Re-estimate after every save.
  useEffect(() => invalidate('reading-time/'), [entry?.version])

  if (!entry || !estimate.data) return null

  return (
    <div className="p-4 text-sm text-text">
      <p className="m-0 text-2xl font-semibold text-ink">{t('{minutes} min', { minutes: estimate.data.minutes })}</p>
      <p className="m-0 mt-1 text-muted">{plural(estimate.data.words, '{count} word', '{count} words')}</p>
    </div>
  )
}

registry.panels.set('reading-time', { id: 'reading-time', slot: 'entry.sidebar', label: t('Reading time'), icon: 'clock', component: ReadingTimePanel })
```

Every string goes through `t()` (and `plural()` for counts), so the panel speaks the editor's language. Put the translations next to `composer.json` in `lang/nl.json`, `lang/fr.json`… — `{ "Reading time": "Leestijd", "{minutes} min": "{minutes} min" }`; anything missing shows in English. See [Translations](/plugins/admin-extensions#translations).

```json
{
  "name": "@acme/reading-time",
  "private": true,
  "type": "module",
  "scripts": { "build": "vite build" },
  "devDependencies": {
    "@letterncms/admin": "^0.1.0",
    "@letterncms/sdk": "^0.1.0",
    "@letterncms/ui": "^0.1.0",
    "@tanstack/react-query": "5.105.0",
    "@tailwindcss/vite": "4.3.3",
    "@types/react": "19.3.0",
    "@vitejs/plugin-react": "6.1.2",
    "react": "19.3.1",
    "tailwindcss": "4.3.3",
    "typescript": "7.0.2",
    "vite": "8.3.5"
  }
}
```

```javascript
// vite.config.mjs
import { defineConfig } from 'vite'
import { cmsAdminModule } from '@letterncms/admin/vite'

export default defineConfig(cmsAdminModule({ entry: 'admin/src/index.tsx' }))
```

Build it with `npm install && npm run build`, or the same with pnpm or yarn; the output goes to `dist/admin.js`, which `adminModule()` loads. `@letterncms/admin` holds the Vite setup, and `@letterncms/sdk` and `@letterncms/ui` give you the types; the admin provides their code at runtime. Only you need Node, on your own machine: the people who install your plugin get `dist/` with it.

To check your types, add a `tsconfig.json`:

```json
{
  "compilerOptions": { "target": "ES2023", "module": "ESNext", "moduleResolution": "bundler", "jsx": "react-jsx", "strict": true, "skipLibCheck": true, "noEmit": true, "types": ["vite/client"] },
  "include": ["admin/src"]
}
```

## 6. A widget on the home screen

Every plugin brings at least one widget for the home screen — something worth a glance there. People add it from the widget gallery when they customize their home screen; a plugin without one is reported as invalid. Reading time shows the longest reads.

Register it in `boot()`, with a second, read-only ability for its data:

```php
$this->cms()->abilities()->register('reading-time/longest', [
    'label' => 'Longest reads',
    'description' => 'The published entries that take longest to read, and the average reading time.',
    'annotations' => ['readOnly' => true],
    'permission' => 'admin.access',
    'input' => ['type' => 'object', 'properties' => ['limit' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 20, 'default' => 5]]],
    'handler' => function (array $input, AbilityContext $context) { /* … the published entries you may see, longest first … */ },
]);

$this->cms()->admin()->widget('reading-time-longest', [
    'label' => 'Reading time',
    'description' => 'The longest reads among published entries.',   // shown in the gallery
    'icon' => 'clock',
    'column' => 'side',
]);
```

The component goes next to the panel. `Widget` from `@letterncms/ui` draws the header (the registered label and icon), the loading skeleton, errors and the empty state, so it looks like every other widget:

```typescript
import { registry, t, useAbility } from '@letterncms/sdk'
import { Widget, WidgetRow } from '@letterncms/ui'

interface Longest {
  average: number | null
  entries: { id: string; collection: string; title: string; minutes: number }[]
}

function LongestReads() {
  const longest = useAbility<Longest>('reading-time/longest', { limit: 5 })

  return (
    <Widget query={longest} empty={longest.data?.entries.length === 0 && { icon: 'clock', title: t('Nothing published yet') }}>
      {longest.data?.entries.map((e) => (
        <WidgetRow key={e.id} to={`/content/${e.collection}/${e.id}`} icon="file-text" title={e.title} meta={t('{minutes} min', { minutes: e.minutes })} />
      ))}
    </Widget>
  )
}

registry.widgets.set('reading-time-longest', LongestReads)
```

## 7. Turn it on

```bash
php cms plugin enable acme/reading-time
php cms run reading-time/estimate id=01jc8w6m3x9k2h4v5t7r0p1q3s
```

Open any entry: the side panel has a **Reading time** tab. On the home screen, **Customize → Add widget** offers *Reading time*. Ask the assistant "how long does this page take to read?" — it finds the new ability on its own. And **Settings → Reading time** lets editors adjust the speed.
