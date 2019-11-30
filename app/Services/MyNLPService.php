<?php

namespace App\Services;

use Illuminate\Support\Str;

class MyNLPService
{
    const PRONOUNS = ['i', 'we', 'you', 'he', 'she', 'they', 'me', 'us', 'him', 'her', 'them', 'my', 'our', 'his', 'her', 'their', 'mine', 'yours', 'theirs'];
    const PREPOSITIONS = ['to', 'from', 'in', 'at', 'on', 'under'];

    public static function getSeedsFromWords($words)
    {
        $keywords = array_filter($words, function($word) use ($words) {
            $lcWord = strtolower($word);

            return !in_array($lcWord, self::PRONOUNS) && !in_array($lcWord, self::PREPOSITIONS);
        });

        $seeds = array_map(function($word) use ($keywords) {
            return [
                'phrase' => Str::singular($word) ?? $word,
                'ratio' => 1 / count($keywords),
            ];
        }, $keywords);

        return $seeds;
    }

}