<?php

namespace App\Services\Recommendation\Factories;

class SloganSettingsFactory
{

    public static function create($layout, $font, $slogan, $palette)
    {
        if ($layout === 'initial') {
            $fontSize = 15;
        } else if ($layout === 'typography') {
            $fontSize = 20;
        } else {
            $fontSize = 10;
        }

        return [
            'id'        => 0,
            'text'      => $slogan,
            'fontSize'  => $fontSize,
            'fontBounds' => [
                'minX' => 0,
                'minY' => 0,
                'maxX' => 0,
                'maxY' => 0,
            ],
            'fontAdvX' => 0,
            'letterSpace' => 0,
            'lineSpace' => 50,
            'font' => $font,
            'color' => [
                'hex' => $palette->slogan_color,
                'rgba' => [
                    'r' => hexdec(substr($palette->slogan_color, 1, 2)),
                    'g' => hexdec(substr($palette->slogan_color, 3, 2)),
                    'b' => hexdec(substr($palette->slogan_color, 5, 2)),
                    'a' => 1
                ],
                'a' => 1,
            ],
            'capitalization' => $capitalization ?? '',
            'paths' => [],
            'width' => 0,
            'height' => 0,
            'scale' => 1,
        ];
    }
}