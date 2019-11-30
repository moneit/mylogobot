<?php

use Illuminate\Database\Seeder;

class FontRecommendationsTypographyLogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('font_recommendations_typography_logos')->delete();

        $recommendations = [
            ['company_name_font_id' => 86, 'slogan_font_id' => 46,], // Niconne, Raleway
            ['company_name_font_id' => 96, 'slogan_font_id' => 37,], // Engagement, Montserrat
            ['company_name_font_id' => 70, 'slogan_font_id' => 32,], // Lobster, Exo_2
            ['company_name_font_id' => 87, 'slogan_font_id' => 48,], // Pinyon_Script, Questrial

            ['company_name_font_id' => 97, 'slogan_font_id' => 50,], // Delius_Swash_Caps, Dosis
            ['company_name_font_id' => 106, 'slogan_font_id' => 106,], // Romanesco, Romanesco
            ['company_name_font_id' => 88, 'slogan_font_id' => 47,], // Alex_Brush, Quicksand
            ['company_name_font_id' => 98, 'slogan_font_id' => 30,], // Vibur, Vidaloka

            ['company_name_font_id' => 107, 'slogan_font_id' => 8,], // Miss_Fajardose, Vollkorn
            ['company_name_font_id' => 89, 'slogan_font_id' => 49,], // Damion, Poppins
            ['company_name_font_id' => 99, 'slogan_font_id' => 2,], // Sofia, Josefin_Slab
            ['company_name_font_id' => 108, 'slogan_font_id' => 46,], // Monsieur_La_Doulaise, Raleway

            ['company_name_font_id' => 90, 'slogan_font_id' => 57,], // Sacramento, Yanone_Kaffeesatz
            ['company_name_font_id' => 100, 'slogan_font_id' => 52,], // Rouge_Script, Ubuntu
            ['company_name_font_id' => 109, 'slogan_font_id' => 47,], // Lovers_Quarrel, Quicksand
            ['company_name_font_id' => 91, 'slogan_font_id' => 48,], // Cookie, Questrial

            ['company_name_font_id' => 101, 'slogan_font_id' => 50,], // Mr_De_Haviland, Dosis
            ['company_name_font_id' => 92, 'slogan_font_id' => 59,], // Great_Vibes, Titillium_Web
            ['company_name_font_id' => 102, 'slogan_font_id' => 98,], // Norican, Vibur
            ['company_name_font_id' => 93, 'slogan_font_id' => 44,], // Satisfy, Josefin_Sans

            ['company_name_font_id' => 103, 'slogan_font_id' => 56,], // Grand_Hotel, Nunito
            ['company_name_font_id' => 80, 'slogan_font_id' => 89,], // Shrikhand, Damion
            ['company_name_font_id' => 66, 'slogan_font_id' => 89,], // Audiowide, Damion
            ['company_name_font_id' => 95, 'slogan_font_id' => 55,], // Pacifico, Muli

            ['company_name_font_id' => 105, 'slogan_font_id' => 88,], // Berkshire_Swash, Alex_Brush
            ['company_name_font_id' => 71, 'slogan_font_id' => 105,], // Modak, Berkshire_Swash
            ['company_name_font_id' => 81, 'slogan_font_id' => 57,], // Kenia, Yanone_Kaffeesatz
            ['company_name_font_id' => 62, 'slogan_font_id' => 36,], // Black_Ops_One, Allerta_Stencil

            ['company_name_font_id' => 72, 'slogan_font_id' => 106,], // Pirata_One, Romanesco
            ['company_name_font_id' => 82, 'slogan_font_id' => 76,], // Flavors, Mystery_Quest
            ['company_name_font_id' => 73, 'slogan_font_id' => 48,], // Uncial_Antiqua, Questrial
            ['company_name_font_id' => 83, 'slogan_font_id' => 94,], // Henny_Penny, Amatic_SC

            ['company_name_font_id' => 74, 'slogan_font_id' => 94,], // Cherry_Swash, Amatic_SC
            ['company_name_font_id' => 75, 'slogan_font_id' => 75,], // UnifrakturMaguntia, UnifrakturMaguntia
            ['company_name_font_id' => 85, 'slogan_font_id' => 79,], // Plaster, Bungee
            ['company_name_font_id' => 67, 'slogan_font_id' => 69,], // Monoton, Righteous
        ];

        DB::table('font_recommendations_typography_logos')->insert($recommendations);
    }
}
