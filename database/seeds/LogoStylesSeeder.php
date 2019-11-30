<?php

use Illuminate\Database\Seeder;
use App\LogoStyle;

class LogoStylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LogoStyle::truncate();

        $logoStyles = [
            ['id' => 1, 'name' => LogoStyle::IconStyleName, ],
            ['id' => 2, 'name' => LogoStyle::TypographyStyleName, ],
            ['id' => 3, 'name' => LogoStyle::InitialStyleName, ],
        ];

        foreach($logoStyles as $logoStyle) {
            LogoStyle::create($logoStyle);
        }
    }
}
