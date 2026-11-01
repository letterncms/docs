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
