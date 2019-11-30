<?php

namespace App\Services\Recommendation\Factories;

class CompanyNameSettingsFactory
{
    public static function create($layout, $font, $companyName, $palette)
    {
        if ($layout === 'typography') {
            $fontSize = 70;
        } else if ($layout === 'initial') {
            $fontSize = 30;
        } else {
            $fontSize = 20;
        }

        return [
            'id'        => 0,
            'text'      => $companyName,
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
                'hex' => $palette->company_name_color,
                'rgba' => [
                    'r' => hexdec(substr($palette->company_name_color, 1, 2)),
                    'g' => hexdec(substr($palette->company_name_color, 3, 2)),
                    'b' => hexdec(substr($palette->company_name_color, 5, 2)),
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