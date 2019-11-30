<?php

namespace App\Services\Recommendation\Factories;

use App\IconTagFailure;
use App\Services\TheNounProjectService;
use App\Services\SvgIconService;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Promise;

class SymbolSettingsFactory
{
    private static function getIconByPhrase($phrase)
    {
        $tag = TheNounProjectService::getTagFromKeyword($phrase);
        $failure = IconTagFailure::where('tag', '=', $tag)->first();

        if (! is_null($failure)) { // already failed tag
            return null;
        }

        $page = Cache::get($tag.':page');
        $icons = Cache::get($tag.':icons');

        try {
            if (empty($icons)) {
                if (empty($page)) { // if page is not in cache
                    $page = 1;
                } else {
                    $page++;
                }

                $iconsData = TheNounProjectService::getData($tag, $page, 100);

                if (isset($iconsData['body']) && !empty($iconsData['body'])) {
                    $icons = $iconsData['body'];

                    $randIdx = array_rand($icons);
                    $icon = $icons[$randIdx];
                    unset($icons[$randIdx]);
                    $icons = array_values($icons);

                    Cache::put($tag.':page', $page, 10);
                    Cache::put($tag.':icons', $icons, 10);
                } else {
                    if (1 === $page) {
                        IconTagFailure::create([
                            'tag' => $tag,
                        ]);

                        throw new \Exception('Got no icons for tag ' . $tag);
                    } else {
                        Cache::put($tag.':page', 0, 10);
                        Cache::put($tag.':icons', [], 10);

                        return self::getIconByPhrase($phrase);
                    }
                }
            } else {
                $randIdx = array_rand($icons);
                $icon = $icons[$randIdx];
                unset($icons[$randIdx]);
                $icons = array_values($icons);

                Cache::put($tag.':icons', $icons, 10);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return null;
        }

        return $icon;
    }

    private static function removeCacheByPhrase($phrase)
    {
        $tag = TheNounProjectService::getTagFromKeyword($phrase);

        Cache::forget($tag.':page');
        Cache::forget($tag.':icons');
    }

    /**
     * @param $layoutDirection
     * @param $layout
     * @param $font
     * @param $seeds
     * @param $palette
     * @param $companyName
     * @param $client
     *
     * @throws
     * @return mixed
     */
    public static function create($layoutDirection, $layout, $font, $seeds, $palette, $companyName, $client)
    {
        if ($layout === 'icon') {
            $selectedSeedIdx = -1;
            $phrase = null;
            $sum = 100.0;

            while (empty($svgIconService)) {
                while (empty($icon)) {
                    if (empty($seeds)) {
                        if ($phrase === $companyName) {
                            $seeds = [
                                ['phrase' => 'impossible', 'ratio' => 0.33],
                                ['phrase' => 'abstract', 'ratio' => 0.33],
                                ['phrase' => 'logo', 'ratio' => 0.34],
                            ];
                            $sum = 100.0;
                            $selectedSeedIdx = 0;
                        } else {
                            $selectedSeedIdx = -1; // final try with company name
                        }
                    } else {
                        $rand = rand(0, $sum) / 100.0;
                        foreach($seeds as $idx => $seed) {
                            if ($seed['ratio'] >= $rand) {
                                $selectedSeedIdx = $idx;
                                break;
                            } else {
                                $rand = $rand - $seed['ratio'];
                            }
                        }
                    }

                    if ($selectedSeedIdx === -1) {
                        $phrase = $companyName;// final try with company name
                    } else {
                        if (isset($seeds[$selectedSeedIdx])) {// hotfix, check existence, but todo: why sometimes it does not exist?
                            $phrase = $seeds[$selectedSeedIdx]['phrase'];
                        } else {
                            if ($selectedSeedIdx > 0) {
                                $selectedSeedIdx--;
                                $phrase = $seeds[$selectedSeedIdx]['phrase'];
                            } else {
                                $selectedSeedIdx = -1;
                                $phrase = $companyName;// final try with company name
                            }
                        }
                    }

                    $icon = self::getIconByPhrase($phrase);

                    if (is_null($icon)) {
                        if ($selectedSeedIdx === -1) { // company name failed
                            $seeds = [
                                ['phrase' => 'impossible', 'ratio' => 0.33],
                                ['phrase' => 'abstract', 'ratio' => 0.33],
                                ['phrase' => 'logo', 'ratio' => 0.34],
                            ];
                            $sum = 100.0;
                            $selectedSeedIdx = 0;
                        } else {
                            // break phrase by space if possible, refactor seeds
                            if (strpos($phrase, ' ') !== false) {
                                $derivedPhrases = explode(' ', $phrase);
                                foreach($derivedPhrases as $derivedPhrase) {
                                    $seeds[] = [
                                        'phrase' => $derivedPhrase,
                                        'ratio' => $selectedSeedIdx === -1 ? 1.0 / count($derivedPhrases) : $seeds[$selectedSeedIdx]['ratio'] / count($derivedPhrases),
                                    ];
                                }
                            } else {
                                $sum -= (int)($seeds[$selectedSeedIdx]['ratio'] * 100);
                            }

                            unset($seeds[$selectedSeedIdx]);
                            $seeds = array_values($seeds);
                        }
                    }
                }

                $iconUrl = $icon['icon_url'];

                try {
                    return $client->getAsync($iconUrl)->then(function($response) use ($layoutDirection, $palette, $layout) {
                        $svg = $response->getBody();
                        $svgIconService = new SvgIconService($svg);

                        $tags = $svgIconService->asXml();
                        $uniqueId = uniqid();
                        $tags = array_map(function($tag) use ($palette, $uniqueId) {
                            $tag = str_replace('fill:black', 'fill:' . $palette->symbol_color, $tag); // remove black fill
                            $tag = str_replace('fill="black"', 'fill="' . $palette->symbol_color . '"', $tag); // remove black fill

                            $tag = preg_replace('/fill="#[0-9|a-f]{3}"/i', 'fill="' . $palette->symbol_color . '"', $tag); // remove inline fills
                            $tag = preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="' . $palette->symbol_color . '"', $tag); // remove inline fills

                            $tag = preg_replace('/stroke="#[0-9|a-f]{3}"/i', 'stroke="' . $palette->symbol_color . '"', $tag); // remove inline stroke
                            $tag = preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="' . $palette->symbol_color . '"', $tag); // remove inline stroke

                            $tag = preg_replace('/fill:#[0-9|a-f]{3};/i', 'fill:' . $palette->symbol_color . ';', $tag); // remove css fills
                            $tag = preg_replace('/fill:#[0-9|a-f]{6};/i', 'fill:' . $palette->symbol_color . ';', $tag); // remove css fills

                            $tag = preg_replace('/stroke:#[0-9|a-f]{3};/i', 'stroke:' . $palette->symbol_color . ';', $tag); // remove css stroke
                            $tag = preg_replace('/stroke:#[0-9|a-f]{6};/i', 'stroke:' . $palette->symbol_color . ';', $tag); // remove css stroke

                            // hotfix fil0
                            $tag = preg_replace('/fil0/i', 'fil' . $uniqueId, $tag);

                            return $tag;
                        }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove inline fills
//                return preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="' . $palette->symbol_color . '"', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove inline stroke
//                return preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="' . $palette->symbol_color . '"', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove css fills
//                return preg_replace('/fill:#[0-9|a-f]{6};/i', 'fill:' . $palette->symbol_color . ';', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove css stroke
//                return preg_replace('/stroke:#[0-9|a-f]{6};/i', 'stroke:' . $palette->symbol_color . ';', $tag);
//            }, $tags);

                        $bounds = $svgIconService->getBounds();
                        $iconScale = 1;

                        $keys = ['minX', 'minY', 'maxX', 'maxY',];
                        foreach($keys as $key) {
                            while($bounds[$key] * $iconScale != (int)($bounds[$key] * $iconScale)) {
                                $iconScale = $iconScale * 10;
                            }
                        }

                        foreach($svgIconService->getAttributes() as $key => $value) {
                            if ($key === 'clip-rule') {
                                $iconClipRule = (string)$value;
                            }
                            if ($key === 'fill-rule') {
                                $iconFillRule = (string)$value;
                            }
                        }

                        if ($layoutDirection === 'horizontal') {
                            $lineSpace = 60;
                        }

                        return [
                            // icon settings
                            'types' => [
                                [
                                    'label' => 'Icon',// also used as key of type
                                    'icon' => 'logobot-icon icon-gem',
                                    'selected' => $layout !== 'initial',
                                ],
                                [
                                    'label' => 'Initials',
                                    'icon' => 'logobot-icon icon-heading',
                                    'selected' => $layout === 'initial',
                                ],
                            ],
                            'iconId' => 0,
                            'tags' => $tags ?? [],
                            'iconBounds' => $bounds ?? [
                                    'minX' => 0,
                                    'minY' => 0,
                                    'maxX' => 0,
                                    'maxY' => 0,
                                ],
                            'iconClipRule' => $iconClipRule ?? '',
                            'iconFillRule' => $iconFillRule ?? '',
                            'iconSize' => 50,
                            'iconWidth' => 0,
                            'iconHeight' => 0,
                            'iconScale' => $iconScale ?? 1,
                            'iconHidden' => false,

                            // initials settings
                            'initialsId' => 0,
                            'font' => $initialsFont ?? [],
                            'fontSize' => 50,
                            'fontBounds' => [
                                'minX' => 0,
                                'minY' => 0,
                                'maxX' => 0,
                                'maxY' => 0,
                            ],
                            'fontAdvX' => 0,
                            'text' => $text ?? '',
                            'paths' => [],
                            'letterSpace' => 0,
                            'initialsWidth' => 0,
                            'initialsHeight' => 0,
                            'initialsScale' => 1,

                            // settings for icon and initials both
                            'color' => [
                                'hex' => $palette->symbol_color,
                                'rgba' => [
                                    'r' => hexdec(substr($palette->symbol_color, 1, 2)),
                                    'g' => hexdec(substr($palette->symbol_color, 3, 2)),
                                    'b' => hexdec(substr($palette->symbol_color, 5, 2)),
                                    'a' => 1
                                ],
                                'a' => 1,
                            ],
                            'lineSpace' => $lineSpace ?? 50,
                        ];
                    }, function($rej) use ($phrase) {
                        self::removeCacheByPhrase($phrase);
                        \Log::error('content from guzzlehttp failed', [$rej]);
                    });
                } catch(\Exception $e) {
                    // remove cache by phrase
                    self::removeCacheByPhrase($phrase);
                }
            }

            $tags = $svgIconService->asXml();
            $uniqueId = uniqid();
            $tags = array_map(function($tag) use ($palette, $uniqueId) {
                $tag = str_replace('fill:black', 'fill:' . $palette->symbol_color, $tag); // remove black fill
                $tag = str_replace('fill="black"', 'fill="' . $palette->symbol_color . '"', $tag); // remove black fill

                $tag = preg_replace('/fill="#[0-9|a-f]{3}"/i', 'fill="' . $palette->symbol_color . '"', $tag); // remove inline fills
                $tag = preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="' . $palette->symbol_color . '"', $tag); // remove inline fills

                $tag = preg_replace('/stroke="#[0-9|a-f]{3}"/i', 'stroke="' . $palette->symbol_color . '"', $tag); // remove inline stroke
                $tag = preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="' . $palette->symbol_color . '"', $tag); // remove inline stroke

                $tag = preg_replace('/fill:#[0-9|a-f]{3};/i', 'fill:' . $palette->symbol_color . ';', $tag); // remove css fills
                $tag = preg_replace('/fill:#[0-9|a-f]{6};/i', 'fill:' . $palette->symbol_color . ';', $tag); // remove css fills

                $tag = preg_replace('/stroke:#[0-9|a-f]{3};/i', 'stroke:' . $palette->symbol_color . ';', $tag); // remove css stroke
                $tag = preg_replace('/stroke:#[0-9|a-f]{6};/i', 'stroke:' . $palette->symbol_color . ';', $tag); // remove css stroke

                // hotfix fil0
                $tag = preg_replace('/fil0/i', 'fil' . $uniqueId, $tag);

                return $tag;
            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove inline fills
//                return preg_replace('/fill="#[0-9|a-f]{6}"/i', 'fill="' . $palette->symbol_color . '"', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove inline stroke
//                return preg_replace('/stroke="#[0-9|a-f]{6}"/i', 'stroke="' . $palette->symbol_color . '"', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove css fills
//                return preg_replace('/fill:#[0-9|a-f]{6};/i', 'fill:' . $palette->symbol_color . ';', $tag);
//            }, $tags);
//            $tags = array_map(function($tag) use ($palette) {// remove css stroke
//                return preg_replace('/stroke:#[0-9|a-f]{6};/i', 'stroke:' . $palette->symbol_color . ';', $tag);
//            }, $tags);

            $bounds = $svgIconService->getBounds();
            $iconScale = 1;

            $keys = ['minX', 'minY', 'maxX', 'maxY',];
            foreach($keys as $key) {
                while($bounds[$key] * $iconScale != (int)($bounds[$key] * $iconScale)) {
                    $iconScale = $iconScale * 10;
                }
            }

            foreach($svgIconService->getAttributes() as $key => $value) {
                if ($key === 'clip-rule') {
                    $iconClipRule = (string)$value;
                }
                if ($key === 'fill-rule') {
                    $iconFillRule = (string)$value;
                }
            }

            if ($layoutDirection === 'horizontal') {
                $lineSpace = 60;
            }
        } else if ($layout === 'initial') {
            $initialsFont = $font;

            $text = '';
            // if $companyName has space ->  use acronym like IL, else use whole
            $segments = explode(' ', $companyName);
            foreach($segments as $segment) {
                if (strlen($segment) > 0) {
                    $text .= $segment[0];
                }
            }
            $text = strtoupper($text);
        } else if ($layout === 'typography') {
            // do nothing
        }

        return Promise\promise_for([
            // icon settings
            'types' => [
                [
                    'label' => 'Icon',// also used as key of type
                    'icon' => 'logobot-icon icon-gem',
                    'selected' => $layout !== 'initial',
                ],
                [
                    'label' => 'Initials',
                    'icon' => 'logobot-icon icon-heading',
                    'selected' => $layout === 'initial',
                ],
            ],
            'iconId' => 0,
            'tags' => $tags ?? [],
            'iconBounds' => $bounds ?? [
                'minX' => 0,
                'minY' => 0,
                'maxX' => 0,
                'maxY' => 0,
            ],
            'iconClipRule' => $iconClipRule ?? '',
            'iconFillRule' => $iconFillRule ?? '',
            'iconSize' => 50,
            'iconWidth' => 0,
            'iconHeight' => 0,
            'iconScale' => $iconScale ?? 1,
            'iconHidden' => false,

            // initials settings
            'initialsId' => 0,
            'font' => $initialsFont ?? [],
            'fontSize' => 50,
            'fontBounds' => [
                'minX' => 0,
                'minY' => 0,
                'maxX' => 0,
                'maxY' => 0,
            ],
            'fontAdvX' => 0,
            'text' => $text ?? '',
            'paths' => [],
            'letterSpace' => 0,
            'initialsWidth' => 0,
            'initialsHeight' => 0,
            'initialsScale' => 1,

            // settings for icon and initials both
            'color' => [
                'hex' => $palette->symbol_color,
                'rgba' => [
                    'r' => hexdec(substr($palette->symbol_color, 1, 2)),
                    'g' => hexdec(substr($palette->symbol_color, 3, 2)),
                    'b' => hexdec(substr($palette->symbol_color, 5, 2)),
                    'a' => 1
                ],
                'a' => 1,
            ],
            'lineSpace' => $lineSpace ?? 50,
        ]);
    }
}