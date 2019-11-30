<?php

namespace App\Services\Recommendation\Factories;


class SettingsFactory
{
    const logoWidth = 1024;
    const logoHeight = 768;

    public static function create($layoutDirection, $layout, $palette, $hasContainer, $isContainerFilled = NULL)
    {
        if ($layout === 'initial' || $layout === 'typography') {
            $vertical = 1; // use vertical layout for initials and typography logos
        } else {
            $vertical = rand(0, 1);
        }

        return [
            'id'        => 0,
            'layout'    => $layoutDirection.'-'.$layout,
            'backgroundColor' => [
                'hex'   => $hasContainer && $isContainerFilled ? '#FFF' : $palette->bg_color,
            ],
            'width'     => self::logoWidth,
            'height'    => self::logoHeight,
            'scale'     => 1.0,
        ];
    }
}