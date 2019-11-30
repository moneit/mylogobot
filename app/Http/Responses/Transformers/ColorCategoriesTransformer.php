<?php

namespace App\Http\Responses\Transformers;


class ColorCategoriesTransformer
{
    public static function transform($colorCategories)
    {
        $result = [];

        foreach($colorCategories as $colorCategory) {
            $result[] = [
                'id' => $colorCategory->id,
                'name' => $colorCategory->name,
                'colors' => [
                    [$colorCategory->color_1, $colorCategory->color_2, $colorCategory->color_3],
                    [$colorCategory->color_4, $colorCategory->color_5, $colorCategory->color_6],
                    [$colorCategory->color_7, $colorCategory->color_8, $colorCategory->color_9],
                ],
                'checked' => false,
            ];
        }

        return $result;
    }
}