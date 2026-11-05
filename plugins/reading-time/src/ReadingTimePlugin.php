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
                (int) $this->cms()->settings('reading-time', 'words_per_minute', 230),
            ),
        ]);

        // A second one for the home-screen widget: the longest of the published entries you can see.
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
                $wordsPerMinute = (int) $this->cms()->settings('reading-time', 'words_per_minute', 230);

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

        // Templates can show {readingTime.minutes} for the page being rendered.
        $this->cms()->hooks()->addFilter('site.scope', fn (array $scope, $page) => $page->entry
            ? [...$scope, 'readingTime' => $this->app->make(ReadingTime::class)->estimate($page->entry, (int) $this->cms()->settings('reading-time', 'words_per_minute', 230))]
            : $scope);

        // A widget people can add to their home screen; its component is in admin/src/index.tsx.
        $this->cms()->admin()->widget('reading-time-longest', ['label' => 'Reading time', 'description' => __('The longest reads among published entries.'), 'icon' => 'clock', 'column' => 'side', 'order' => 70]);

        $this->adminModule(css: null);
    }
}
