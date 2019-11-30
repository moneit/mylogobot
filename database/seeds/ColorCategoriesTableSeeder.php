<?php

use Illuminate\Database\Seeder;

class ColorCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('color_categories')->delete();

        $colorCategories = [
            [
                'name'    => 'Clean',
                'color_1' => '#2ECC71',
                'color_2' => '#3498DB',
                'color_3' => '#9B59B6',
                'color_4' => '#2980B9',
                'color_5' => '#1ABC9C',
                'color_6' => '#ECF0F1',
                'color_7' => '#BDC3C7',
                'color_8' => '#34495E',
                'color_9' => '#BDC3C7',
            ],
            [
                'name'    => 'Vibrant',
                'color_1' => '#F44336',
                'color_2' => '#9C27B0',
                'color_3' => '#FFC107',
                'color_4' => '#CDDC39',
                'color_5' => '#03A9F4',
                'color_6' => '#8BC34A',
                'color_7' => '#FF9800',
                'color_8' => '#FF5722',
                'color_9' => '#E91E63',
            ],
            [
                'name'    => 'Warm',
                'color_1' => '#FF5252',
                'color_2' => '#FF793F',
                'color_3' => '#AAA69D',
                'color_4' => '#FFB142',
                'color_5' => '#FFDA79',
                'color_6' => '#CC8E35',
                'color_7' => '#CCAE62',
                'color_8' => '#B33939',
                'color_9' => '#F7F1E3',
            ],
            [
                'name'    => 'Dark',
                'color_1' => '#2F3640',
                'color_2' => '#353B48',
                'color_3' => '#718093',
                'color_4' => '#192A56',
                'color_5' => '#40739E',
                'color_6' => '#DCDDE1',
                'color_7' => '#000000',
                'color_8' => '#686868',
                'color_9' => '#333333',
            ],
        ];

        DB::table('color_categories')->insert($colorCategories);
    }
}
