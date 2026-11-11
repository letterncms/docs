---
id: 01m5wn8ra43mwhmr52e5p62qx4
title: Your first plugin
position: 0
description: Build a small reading-time plugin, step by step, using the same pieces Lettern's own plugins are made of.
---
In this tutorial you build **Reading time**: a plugin that works out how long an entry takes to read. It's small, but it touches everything a real plugin does, so by the end you'll know your way around.

These docs run it: the "min read" under this page's title comes from it. The [complete plugin](https://github.com/letterncms/docs/tree/main/plugins/reading-time) is on GitHub.

## What you'll build

One folder, and when it's on:

- **Settings → Reading time** lets editors set how fast people read.
- Editors see the estimate in a **Reading time** tab while they write.
- Designers can show `{readingTime.minutes}` on any page, with no template code.
- The assistant, the API and the command line can ask for an estimate.
- The Dashboard gets a widget with the longest reads.

## 1. Make the folder

Create a folder in your site's `plugins/` folder. When you're done, it holds this:

```text
plugins/reading-time/
  composer.json               who the plugin is and what it needs
  src/ReadingTimePlugin.php   what it adds to Lettern
  src/ReadingTime.php         the estimate itself
  admin/src/index.tsx         the editor panel and the widget
  lang/nl.json, lang/fr.json  translations
  package.json                the admin build's packages
  vite.config.mjs             the admin build
  tsconfig.json               type checking
  dist/admin.js               the built admin code
```

## 2. Describe the package

Every plugin is a Composer package. `composer.json` gives it a name, says what it needs, and points Lettern at its provider class under `extra.cms`.

```json
{
    "name": "acme/reading-time",
    "description": "Estimates reading time for entries.",
    "type": "cms-plugin",
    "version": "1.0.0",
    "license": "MIT",
    "require": {
        "letterncms/cms": "*"
    },
    "autoload": { "psr-4": { "Acme\\ReadingTime\\": "src/" } },
    "extra": {
        "cms": {
            "label": "Reading time",
            "icon": "clock",
            "provider": "Acme\\ReadingTime\\ReadingTimePlugin",
            "modules": ["letterncms/blocks"]
        }
    }
}
```

`require` names the Lettern version (`letterncms/cms`) and the other plugins this one needs. They are real Composer packages, so `composer require` brings them along. Without Composer, Lettern checks the same list and keeps the plugin off until it's met. `modules` names the parts of Lettern it builds on that a site can switch off: the plugin only runs while they're on.

## 3. Write the estimate

This is plain PHP with nothing Lettern-specific about it, apart from reading the entry. It counts the words in the title and every field, and divides by the reading speed.

```php
<?php

namespace Acme\ReadingTime;

use Cms\Modules\Blocks\Document;
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

`Document::text()` turns a page's blocks into plain text. It comes from the Blocks module, which is why `composer.json` lists `letterncms/blocks` under `modules`.

## 4. Add a setting and an ability

The **provider** is the class Lettern starts when the plugin is on. It extends `Cms\Packages\Plugin`: bind your services in `register()`, and add everything else in `boot()`.

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
        $this->cms()->settingsRegistry()->register('reading-time', __('Reading time'), [
            ['handle' => 'words_per_minute', 'type' => 'number', 'label' => 'Words per minute', 'default' => 230, 'min' => 50],
        ], icon: 'clock');

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
                (int) $this->cms()->setting('reading-time', 'words_per_minute', 230),
            ),
        ]);

        $this->adminModule(css: null);
    }
}
```

Two things happen here:

- **A setting.** Declaring one field is enough for a page under **Plugins** in the settings sidebar, with its save bar and API. See [Settings](/plugins/settings).
- **An ability.** An [ability](/agents/abilities) is a named action with a description, an input schema and a permission. Register it once, and the admin, the REST API, AI agents and the command line can all run it. The permission is a closure here because it depends on the entry: you may only estimate entries you can see.

`adminModule()` loads the admin code you write in step 6. `css: null` says this plugin brings no stylesheet of its own.

## 5. Give designers a value

Pages are designed in the browser, so instead of a template function, the plugin adds the estimate to the data pages are rendered with. Add this to `boot()`:

```php
// Templates can show {readingTime.minutes} for the page being rendered.
$this->cms()->hooks()->addFilter('site.scope', fn (array $scope, $page) => $page->entry
    ? [...$scope, 'readingTime' => $this->app->make(ReadingTime::class)->estimate($page->entry, (int) $this->cms()->setting('reading-time', 'words_per_minute', 230))]
    : $scope);
```

`site.scope` is a [hook](/plugins/hooks): a filter that lets you change a value on its way through. Now a designer opens the article template, adds a **Text** block under the title and connects its text to `{readingTime.minutes} min read`. The value is right on every page.

## 6. Add a panel to the editor

The admin is built with React. Your plugin's admin code is a small module that the admin loads; React, `@letterncms/sdk` and `@letterncms/ui` come from the admin, so the bundle holds only your code.

```typescript
// admin/src/index.tsx
import { invalidate, plural, registry, t, useAbility, type Entry } from '@letterncms/sdk'
import { useEffect } from 'react'

function ReadingTimePanel({ entry }: { entry: Entry | null }) {
  const estimate = useAbility<{ words: number; minutes: number }>('reading-time/estimate', { id: entry?.id ?? '' }, { enabled: !!entry })

  // Re-estimate after every save.
  useEffect(() => invalidate('reading-time/'), [entry?.updatedAt])

  if (!entry || !estimate.data) return null

  return (
    <div className="p-4 text-sm text-text">
      <p className="m-0 text-2xl font-semibold text-ink">{t('{minutes} min', { minutes: estimate.data.minutes })}</p>
      <p className="m-0 mt-1 text-muted">{plural(estimate.data.words, '{count} word', '{count} words')}</p>
    </div>
  )
}

registry.panels.set('reading-time', { slot: 'entry.sidebar', label: t('Reading time'), icon: 'clock', component: ReadingTimePanel })
```

`useAbility` runs the ability you registered in step 4, with the signed-in person's permissions. `registry.panels` puts the component in a named place: `entry.sidebar` is a tab in the entry editor's side panel. See [Admin extensions](/plugins/admin-extensions) for every slot.

### Translate it

Every string goes through `t()`, and counts through `plural()`, so the panel speaks the editor's language. Put the translations next to `composer.json`, in `lang/nl.json`, `lang/fr.json` and so on. Part of `lang/nl.json`:

```json
{
  "{count} word": "{count} woord",
  "{count} words": "{count} woorden",
  "{minutes} min": "{minutes} min",
  "Reading time": "Leestijd"
}
```

Anything missing shows in English. See [Translations](/plugins/admin-extensions#translations).

### Build it

Three files set up the build. `package.json`:

```json
{
  "name": "@acme/reading-time",
  "private": true,
  "license": "MIT",
  "type": "module",
  "scripts": {
    "build": "vite build"
  },
  "devDependencies": {
    "@letterncms/admin": "^0.1.0",
    "@letterncms/sdk": "^0.1.0",
    "@letterncms/ui": "^0.1.0",
    "@tailwindcss/vite": "4.3.3",
    "@vitejs/plugin-react": "6.1.2",
    "react": "19.3.1",
    "vite": "8.3.5"
  }
}
```

`vite.config.mjs`:

```javascript
import { defineConfig } from 'vite'
import { cmsAdminModule } from '@letterncms/admin/vite'

export default defineConfig(cmsAdminModule({ entry: 'admin/src/index.tsx' }))
```

And `tsconfig.json`, so your editor can check your types:

```json
{
  "compilerOptions": {
    "target": "ES2023",
    "lib": ["ES2023", "DOM", "DOM.Iterable"],
    "module": "ESNext",
    "moduleResolution": "bundler",
    "jsx": "react-jsx",
    "strict": true,
    "noUncheckedIndexedAccess": false,
    "noFallthroughCasesInSwitch": true,
    "noUnusedLocals": true,
    "noUnusedParameters": true,
    "verbatimModuleSyntax": true,
    "isolatedModules": true,
    "skipLibCheck": true,
    "resolveJsonModule": true,
    "noEmit": true,
    "types": ["vite/client"]
  },
  "include": ["admin/src"]
}
```

Run `npm install && npm run build`, or the same with pnpm or yarn. The output goes to `dist/admin.js`, which `adminModule()` loads.

`@letterncms/admin` holds the Vite setup. `@letterncms/sdk` and `@letterncms/ui` give you the types; the admin provides their code at runtime. Only you need Node, on your own machine: people who install your plugin get `dist/` with it.

## 7. Add a Dashboard widget

Every plugin brings at least one widget for the Dashboard: something worth a glance. A plugin without one is reported as invalid. Reading time shows the longest reads.

In `boot()`, register a second read-only ability for the widget's data, and the widget itself:

```php
// A second one for the Dashboard widget: the longest of the published entries you can see.
$this->cms()->abilities()->register('reading-time/longest', [
    'label' => 'Longest reads',
    'description' => 'The published entries that take longest to read, and the average reading time.',
    'annotations' => ['readOnly' => true],
    'permission' => 'admin.access',
    'input' => [
        'type' => 'object',
        'properties' => ['limit' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 20, 'default' => 5]],
    ],
    'handler' => function (array $input, AbilityContext $context) {
        $collections = array_keys(array_filter(
            $this->cms()->collections()->all(),
            fn ($collection) => $collection->routable() && ($context->system || $context->user?->hasPermission("entries.{$collection->handle}.view")),
        ));
        // The 200 published last are plenty for an overview.
        $entries = $collections ? $this->cms()->entries()->query()->collection(...$collections)->live()->orderBy('-published_at')->limit(200)->get() : [];
        $wordsPerMinute = (int) $this->cms()->setting('reading-time', 'words_per_minute', 230);

        $reads = array_map(fn ($entry) => [
            'id' => $entry->id,
            'collection' => $entry->collection,
            'title' => $entry->title,
            ...$this->app->make(ReadingTime::class)->estimate($entry, $wordsPerMinute),
        ], $entries);
        usort($reads, fn ($a, $b) => $b['words'] <=> $a['words']);

        return [
            'average' => $reads ? round(array_sum(array_column($reads, 'minutes')) / count($reads), 1) : null,
            'entries' => array_slice($reads, 0, $input['limit']),
        ];
    },
]);

// A widget people can add to their Dashboard; its component is in admin/src/index.tsx.
$this->cms()->admin()->widget('reading-time-longest', ['label' => 'Reading time', 'description' => __('The longest reads among published entries.'), 'icon' => 'clock', 'column' => 'side', 'order' => 70]);
```

The description is what people see in the widget gallery. Then add the component to `admin/src/index.tsx`. `Widget` from `@letterncms/ui` draws the title (the registered label), loading, errors and the empty state, so it looks like every other widget:

```typescript
import { Widget, WidgetRow } from '@letterncms/ui'

interface Longest {
  average: number | null
  entries: { id: string; collection: string; title: string; minutes: number }[]
}

// A Dashboard widget: <Widget> draws the title, loading, error and empty states.
function LongestReads() {
  const longest = useAbility<Longest>('reading-time/longest', { limit: 5 })
  const average = longest.data?.average

  return (
    <Widget
      query={longest}
      action={average != null && <span className="text-xs text-faint">{t('{minutes} min on average', { minutes: average })}</span>}
      empty={longest.data?.entries.length === 0 && { icon: 'clock', title: t('Nothing published yet') }}
    >
      {longest.data?.entries.map((e) => (
        <WidgetRow key={e.id} to={`/content/${e.collection}/${e.id}`} icon="file-text" title={e.title} meta={t('{minutes} min', { minutes: e.minutes })} />
      ))}
    </Widget>
  )
}

registry.widgets.set('reading-time-longest', LongestReads)
```

Build again.

## 8. Turn it on

Turn the plugin on with its switch in **Plugins**, or from the command line. Then try the ability right away:

```bash
php cms plugin enable acme/reading-time
php cms run reading-time/estimate id=01jc8w6m3x9k2h4v5t7r0p1q3s
```

Now look around:

- Open any entry: the side panel has a **Reading time** tab.
- On the Dashboard, **Customize**, then **Add Widget**, offers *Reading time*.
- Ask the assistant "how long does this page take to read?" It finds the new ability on its own.
- **Reading time**, under **Plugins** in the settings sidebar, lets editors adjust the speed. Its row in **Plugins** opens it too.

## Next

[How plugins work](/plugins/how-plugins-work) explains everything a plugin package can hold, from blocks to collections.
