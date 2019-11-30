<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();

        $products = [
            [ 'iso_code' => 'USD', 'symbol' => '$' ],
        ];

        DB::table('currencies')->insert($products);
    }
}
