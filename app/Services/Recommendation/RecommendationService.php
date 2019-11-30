<?php

namespace App\Services\Recommendation;

use App\Color;
use App\Palette;
use App\FontRecommendationsIconLogo;
use App\FontRecommendationsInitialsLogo;
use App\FontRecommendationsTypographyLogo;
use App\Services\Recommendation\Factories\SettingsFactory;
use App\Services\Recommendation\Factories\CompanyNameSettingsFactory;
use App\Services\Recommendation\Factories\SloganSettingsFactory;
use App\Services\Recommendation\Factories\SymbolSettingsFactory;
use App\Services\Recommendation\Factories\ContainerSettingsFactory;
use App\Services\Google\Language\Service as GoogleLanguageService;
use App\Services\MyNLPService;
use GuzzleHttp\Promise\Promise;

class RecommendationService
{
    /**
     * @param $companyName
     * @param $slogan
     * @param $seeds
     * @param $layout
     * @param $colorIds
     * @param $client
     *
     * @return Promise
     */
    public function getRecommendedLogo($companyName, $slogan, $seeds, $layout, $colorIds, $client)
    {
        // set default layout
        if (empty($layout)) {
            $rand = rand(0, 2);
            $layout = ['icon', 'typography', 'initial'][$rand];
        }

        // set palette for bg color and fg color
        if (count($colorIds) > 0) {
            $idx = rand(0, count($colorIds) - 1);
            $color = Color::findOrFail($colorIds[$idx]);
            $palettes = $color->palettes;

            if (count($palettes) > 0) {
                $idx = rand(0, count($palettes) - 1);
                $palette = $palettes[$idx];
            }
        }

        // set random palette if there is no color category request from front-end
        if (empty($palette)) {
            $palette = Palette::inRandomOrder()->firstOrFail();
        }

        // set random container and container type
        $isContainerFilled = NULL;
//        $hasContainer = rand(0, 1); // remove container in recommendation
        $hasContainer = 0;
        if ($hasContainer) {
            $isContainerFilled = rand(0, 1);
        }

        $fontRecommendation = NULL;

        if ($layout === 'typography') {
            $fontRecommendation = FontRecommendationsTypographyLogo::inRandomOrder()->firstOrFail();
        } else if ($layout === 'icon') {
            $fontRecommendation = FontRecommendationsIconLogo::inRandomOrder()->firstOrFail();
        } else if ($layout === 'initial') {
            $fontRecommendation = FontRecommendationsInitialsLogo::inRandomOrder()->firstOrFail();
            $initialsFont = optional($fontRecommendation)->initialsFont;
        }

        $companyNameFont = optional($fontRecommendation)->companyNameFont;
        $sloganFont = optional($fontRecommendation)->sloganFont;
        $initialsFont = $initialsFont ?? $companyNameFont;

        if ($layout === 'initial' || $layout === 'typography') {
            $layoutDirection = 'vertical'; // use vertical layout for initials and typography logos
        } else {
            $vertical = rand(0, 1);
            $layoutDirection = $vertical ? 'vertical' : 'horizontal';
        }

        $setting = SettingsFactory::create($layoutDirection, $layout, $palette, $hasContainer, $isContainerFilled);
        $companyNameSetting = CompanyNameSettingsFactory::create($layout, $companyNameFont, $companyName, $palette);
        $sloganSetting = SloganSettingsFactory::create($layout, $sloganFont, $slogan, $palette);
//        $symbolSetting = SymbolSettingsFactory::create($layoutDirection, $layout, $initialsFont, $seeds, $palette, $companyName);
        $containerSetting = ContainerSettingsFactory::create($hasContainer, $isContainerFilled, $palette);

        return SymbolSettingsFactory::create($layoutDirection, $layout, $initialsFont, $seeds, $palette, $companyName, $client)
            ->then(function($symbolSetting) use ($setting, $companyNameSetting, $sloganSetting, $containerSetting) {
                return [
                    'settings' => $setting,
                    'companyNameSettings' => $companyNameSetting,
                    'sloganSettings' => $sloganSetting,
                    'symbolSettings' => $symbolSetting,
                    'containerSettings' => $containerSetting,
                ];
            }, function($failed) {
                return null;
            });

//        if (is_null($symbolSetting)) return null;

//        return [
//            'settings' => $setting,
//            'companyNameSettings' => $companyNameSetting,
//            'sloganSettings' => $sloganSetting,
//            'symbolSettings' => $symbolSetting,
//            'containerSettings' => $containerSetting,
//        ];
    }

    public function GetKeyWordsFromNameAndDescription($companyName, $companyDetails)
    {
        $googleLanguageService = new GoogleLanguageService();
        $seeds = $googleLanguageService->getSeeds($companyDetails);

        if (count($seeds) === 0) {
            $words = explode(' ', $companyDetails);
            // $words = array_merge($words, explode(' ', $companyName));
            $seeds = MyNLPService::getSeedsFromWords($words);
        }

        return $seeds;
    }
}