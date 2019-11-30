<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(CountriesTableSeeder::class);
         $this->call(FontsTableSeeder::class);
         $this->call(ColorsTableSeeder::class);
         $this->call(PalettesTableSeeder::class);
         $this->call(ContainersTableSeeder::class);
         $this->call(ColorCategoriesTableSeeder::class);
         $this->call(ColorCategoryPaletteTableSeeder::class);
         $this->call(PackagesTableSeeder::class);
         $this->call(CouponsTableSeeder::class);
         $this->call(CurrenciesTableSeeder::class);
         $this->call(SendgridListTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(FontRecommendationsIconLogosTableSeeder::class);
         $this->call(FontRecommendationsInitialsLogosTableSeeder::class);
         $this->call(FontRecommendationsTypographyLogosTableSeeder::class);
    }
}
