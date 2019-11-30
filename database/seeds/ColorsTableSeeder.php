<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->delete();

        $colors = array(
            array('name' => 'red',      'hex' => '#FF3838'),
            array('name' => 'orange',   'hex' => '#FF9F1A'),
            array('name' => 'yellow',   'hex' => '#FFF200'),
            array('name' => 'green',    'hex' => '#32FF7E'),
            array('name' => 'blue',     'hex' => '#17C0EB'),
            array('name' => 'purple',   'hex' => '#C56CF0'),
            array('name' => 'pink',     'hex' => '#FFB8B8'),
            array('name' => 'grey',     'hex' => '#4B4B4B'),

        );

        DB::table('colors')->insert($colors);
    }
}
