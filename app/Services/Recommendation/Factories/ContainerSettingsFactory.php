<?php

namespace App\Services\Recommendation\Factories;

use App\Container;

class ContainerSettingsFactory
{
    public static function create($hasContainer, $isContainerFilled, $palette)
    {
        if ($isContainerFilled) {
            $color = $palette->bg_color;
        } else {
            $color = $palette->fg_color;// todo: add container color in palettes table
        }

        return [
            'id'=> 0, // id of pivot table
            'types'=> [
                [
                    'label'=> 'Filled',// also used as key of type
                    'icon'=> 'icon-certificate',
                    'selected'=> true,
                ],
                [
                    'label'=> 'Outlined',
                    'icon'=> 'icon-certificate-outline',
                ],
            ],
            'list'=> [],
            'shapes'=> [],
            'color' => [
                'hex' => $color,
                'rgba' => [
                    'r' => hexdec(substr($color, 1, 2)),
                    'g' => hexdec(substr($color, 3, 2)),
                    'b' => hexdec(substr($color, 5, 2)),
                    'a' => 1
                ],
                'a' => 1,
            ],
            'size'=> 50,
            'selected'=> $hasContainer ? Container::where('filled', '=', $isContainerFilled)->inRandomOrder()->firstOrFail(): [],
            'viewBox'=> [
                'maxX'=> 0,
                'maxY'=> 0,
                'minX'=> 0,
                'minY'=> 0,
            ],
        ];
    }
}