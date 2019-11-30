<?php

use Illuminate\Database\Seeder;

class FontRecommendationsIconLogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('font_recommendations_icon_logos')->delete();

        $recommendations = [
            ['company_name_font_id' => 33, 'slogan_font_id' => 46,], // Paytone, Raleway
            ['company_name_font_id' => 31, 'slogan_font_id' => 22,], // Roboto, Roboto_Slab
            ['company_name_font_id' => 32, 'slogan_font_id' => 32,], // Exo_2, Exo_2
            ['company_name_font_id' => 35, 'slogan_font_id' => 89,], // Anton, Damion

            ['company_name_font_id' => 36, 'slogan_font_id' => 40,], // Allerta_Stencil, Oswald
            ['company_name_font_id' => 37, 'slogan_font_id' => 93,], // Montserrat, Satisfy
            ['company_name_font_id' => 34, 'slogan_font_id' => 47,], // Lato, QuickSand
            ['company_name_font_id' => 38, 'slogan_font_id' => 57,], // Fjalla_One, Yanone_Kaffeesatz

            ['company_name_font_id' => 39, 'slogan_font_id' => 93,], // Russo_One, Montserrat
            ['company_name_font_id' => 42, 'slogan_font_id' => 45,], // Orbitron, Play
            ['company_name_font_id' => 43, 'slogan_font_id' => 54,], // Rubik_Mono_One, Asap
            ['company_name_font_id' => 44, 'slogan_font_id' => 95,], // Josefin_Sans, Pacifico

            ['company_name_font_id' => 44, 'slogan_font_id' => 93,], // Josefin_Sans, Montserrat
            ['company_name_font_id' => 45, 'slogan_font_id' => 45,], // Play, Play
            ['company_name_font_id' => 94, 'slogan_font_id' => 91,], // Amatic_Sc, Cookie
            ['company_name_font_id' => 47, 'slogan_font_id' => 48,], // QuickSand, Questrial

            ['company_name_font_id' => 48, 'slogan_font_id' => 70,], // Questrial, Lobster
            ['company_name_font_id' => 49, 'slogan_font_id' => 49,], // Poppins, Poppins
            ['company_name_font_id' => 50, 'slogan_font_id' => 56,], // Dosis, Nunito
            ['company_name_font_id' => 51, 'slogan_font_id' => 57,], // Acme, Yanone_Kaffeesatz

            ['company_name_font_id' => 52, 'slogan_font_id' => 23,], // Ubuntu, Rokkitt
            ['company_name_font_id' => 52, 'slogan_font_id' => 52,], // Ubuntu, Ubuntu
            ['company_name_font_id' => 54, 'slogan_font_id' => 54,], // Asap, Asap
            ['company_name_font_id' => 55, 'slogan_font_id' => 46,], // Muli, Raleway

            ['company_name_font_id' => 59, 'slogan_font_id' => 59,], // Titillium_Web, Titillium_Web
            ['company_name_font_id' => 60, 'slogan_font_id' => 41,], // Teko, Cabin
            ['company_name_font_id' => 61, 'slogan_font_id' => 61,], // Squada_One, Squada_One
            ['company_name_font_id' => 62, 'slogan_font_id' => 36,], // Black_Ops_One, Allerta_Stencil

            ['company_name_font_id' => 72, 'slogan_font_id' => 60,], // Pirata_One, Teko
            ['company_name_font_id' => 63, 'slogan_font_id' => 54,], // Baloo, Asap
            ['company_name_font_id' => 64, 'slogan_font_id' => 41,], // Fugaz_One, Cabin
            ['company_name_font_id' => 65, 'slogan_font_id' => 38,], // Carter_One, Fjalla_One

            ['company_name_font_id' => 85, 'slogan_font_id' => 60,], // Plaster, Teko
            ['company_name_font_id' => 66, 'slogan_font_id' => 89,], // Audiowide, Damion
            ['company_name_font_id' => 68, 'slogan_font_id' => 98,], // Abril_Fatface, Vibur
            ['company_name_font_id' => 78, 'slogan_font_id' => 37,], // Titan_One, Montserrat

            ['company_name_font_id' => 69, 'slogan_font_id' => 88,], // Righteous, Alex_Brush
            ['company_name_font_id' => 79, 'slogan_font_id' => 31,], // Bungee, Roboto
            ['company_name_font_id' => 80, 'slogan_font_id' => 89,], // Shrikhand, Damion
            ['company_name_font_id' => 69, 'slogan_font_id' => 45,], // Righteous, Play

            ['company_name_font_id' => 6, 'slogan_font_id' => 106,], // Montaga, Romanesco
            ['company_name_font_id' => 7, 'slogan_font_id' => 61,], // Bitter, Squada_One
            ['company_name_font_id' => 9, 'slogan_font_id' => 37,], // Holtwood_One_Sc, Montserrat
            ['company_name_font_id' => 10, 'slogan_font_id' => 10,], // Libre_Baskerville, Libre_Baskerville

            ['company_name_font_id' => 11, 'slogan_font_id' => 88,], // Playfair_Display_Sc, Alex_Brush
            ['company_name_font_id' => 15, 'slogan_font_id' => 95,], // Suez_One, Pacifico
            ['company_name_font_id' => 16, 'slogan_font_id' => 48,], // Merriweather, Questrial
            ['company_name_font_id' => 18, 'slogan_font_id' => 18,], // Alegreya, Alegreya

            ['company_name_font_id' => 22, 'slogan_font_id' => 31,], // Roboto_Slab, Roboto
            ['company_name_font_id' => 29, 'slogan_font_id' => 1,], // Cinzel, Bree_Serif
            ['company_name_font_id' => 27, 'slogan_font_id' => 8,], // Pridi, Vollkorn
            ['company_name_font_id' => 30, 'slogan_font_id' => 92,], // Vidaloka, Great_Vibes
        ];

        DB::table('font_recommendations_icon_logos')->insert($recommendations);
    }
}
