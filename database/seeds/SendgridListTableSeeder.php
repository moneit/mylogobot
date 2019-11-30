<?php

use Illuminate\Database\Seeder;

class SendgridListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sendgrid_lists')->delete();

        $lists = [
            ['id' => env('SENDGRID_NOT_BUYERS_LIST_ID'), 'name' => 'Not Buyers'],
            ['id' => env('SENDGRID_BUYERS_LIST_ID'), 'name' => 'Buyers'],
        ];

        DB::table('sendgrid_lists')->insert($lists);
    }
}
