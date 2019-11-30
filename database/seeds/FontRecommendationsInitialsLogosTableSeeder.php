<?php

use Illuminate\Database\Seeder;

class FontRecommendationsInitialsLogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('font_recommendations_initials_logos')->delete();

        $recommendations = [
            ['initials_font_id' => 85, 'company_name_font_id' => 33, 'slogan_font_id' => 46,], // Plaster, Paytone_One, Raleway
            ['initials_font_id' => 93, 'company_name_font_id' => 37, 'slogan_font_id' => 93,], // Satisfy, Montserrat, Satisfy
            ['initials_font_id' => 74, 'company_name_font_id' => 32, 'slogan_font_id' => 32,], // Cherry_Swash, Exo_2, Exo_2
            ['initials_font_id' => 70, 'company_name_font_id' => 33, 'slogan_font_id' => 46,], // Lobster, Paytone_One, Raleway

            ['initials_font_id' => 62, 'company_name_font_id' => 36, 'slogan_font_id' => 40,], // Black_Ops_One, Allerta_Stencil, Oswald
            ['initials_font_id' => 42, 'company_name_font_id' => 42, 'slogan_font_id' => 45,], // Orbitron, Orbitron, Play
            ['initials_font_id' => 106, 'company_name_font_id' => 34, 'slogan_font_id' => 47,], // Romanesco, Lato, Quicksand
            ['initials_font_id' => 95, 'company_name_font_id' => 44, 'slogan_font_id' => 95,], // Pacifico, Josefin_Sans, Pacifico

            ['initials_font_id' => 39, 'company_name_font_id' => 39, 'slogan_font_id' => 37,], // Russo_One, Russo_One, Montserrat
            ['initials_font_id' => 105, 'company_name_font_id' => 49, 'slogan_font_id' => 49,], // Berkshire_Swash, Poppins, Poppins
            ['initials_font_id' => 105, 'company_name_font_id' => 105, 'slogan_font_id' => 61,], // Berkshire_Swash, Berkshire_Swash, Squada_One
            ['initials_font_id' => 62, 'company_name_font_id' => 62, 'slogan_font_id' => 36,], // Black_Ops_One, Black_Ops_One, Allerta_Stencil

            ['initials_font_id' => 108, 'company_name_font_id' => 44, 'slogan_font_id' => 37,], // Monsieur_La_Doulaise, Josefin_Sans, Montserrat
            ['initials_font_id' => 70, 'company_name_font_id' => 60, 'slogan_font_id' => 41,], // Lobster, Teko, Cabin
            ['initials_font_id' => 67, 'company_name_font_id' => 64, 'slogan_font_id' => 41,], // Monoton, Fugaz_One, Cabin
            ['initials_font_id' => 90, 'company_name_font_id' => 65, 'slogan_font_id' => 38,], // Sacramento, Carter_One, Fjalla_One

            ['initials_font_id' => 72, 'company_name_font_id' => 72, 'slogan_font_id' => 60,], // Pirata_One, Pirata_One, Teko
            ['initials_font_id' => 76, 'company_name_font_id' => 63, 'slogan_font_id' => 54,], // Mystery_Quest, Baloo, Asap
            ['initials_font_id' => 107, 'company_name_font_id' => 68, 'slogan_font_id' => 54,], // Miss_Fajardose, Abril_Fatface, Asap
            ['initials_font_id' => 81, 'company_name_font_id' => 78, 'slogan_font_id' => 37,], // Kenia, Titan_One, Montserrat

            ['initials_font_id' => 85, 'company_name_font_id' => 85, 'slogan_font_id' => 60,], // Plaster, Plaster, Teko
            ['initials_font_id' => 66, 'company_name_font_id' => 66, 'slogan_font_id' => 89,], // Audiowide, Audiowide, Damion
            ['initials_font_id' => 80, 'company_name_font_id' => 80, 'slogan_font_id' => 89,], // Shrikhand, Shrikhand, Damion
            ['initials_font_id' => 69, 'company_name_font_id' => 69, 'slogan_font_id' => 45,], // Righteous, Righteousd, Play

            ['initials_font_id' => 88, 'company_name_font_id' => 69, 'slogan_font_id' => 88,], // Alex_Brush, Righteousd, Alex_Brush
            ['initials_font_id' => 100, 'company_name_font_id' => 7, 'slogan_font_id' => 61,], // Rouge_Script, Bitter, Squada_One
            ['initials_font_id' => 9, 'company_name_font_id' => 9, 'slogan_font_id' => 37,], // Holtwood_One_Sc, Holtwood_One_Sc, Montserrat
            ['initials_font_id' => 71, 'company_name_font_id' => 5, 'slogan_font_id' => 89,], // Modak, Ultra, Damion

            ['initials_font_id' => 106, 'company_name_font_id' => 6, 'slogan_font_id' => 106,], // Romanesco, Montaga, Romanesco
            ['initials_font_id' => 95, 'company_name_font_id' => 15, 'slogan_font_id' => 95,], // Pacifico, Suez_One, Pacifico
            ['initials_font_id' => 101, 'company_name_font_id' => 16, 'slogan_font_id' => 48,], // Mr_De_Haviland, Merriweather, Questrial
            ['initials_font_id' => 10, 'company_name_font_id' => 10, 'slogan_font_id' => 10,], // Libre_Baskerville, Libre_Baskerville, Libre_Baskerville

            ['initials_font_id' => 88, 'company_name_font_id' => 11, 'slogan_font_id' => 88,], // Alex_Brush, Playfair_Display_Sc, Alex_Brush
            ['initials_font_id' => 29, 'company_name_font_id' => 29, 'slogan_font_id' => 1,], // Cinzel, Cinzel, Bree_Serif
            ['initials_font_id' => 100, 'company_name_font_id' => 27, 'slogan_font_id' => 8,], // Rouge_Script, Pridi, Vollkorn
            ['initials_font_id' => 109, 'company_name_font_id' => 30, 'slogan_font_id' => 92,], // Lovers_Quarrel, Vidaloka, Great_Vibes
        ];

        DB::table('font_recommendations_initials_logos')->insert($recommendations);
    }
}
