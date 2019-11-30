<?php

use Illuminate\Database\Seeder;
use App\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->delete();

        $products = [
            [ 'code' => 'LB5', 'discount_rate' => 5 ],
            [ 'code' => 'LB10', 'discount_rate' => 10 ],
            [ 'code' => 'LB20', 'discount_rate' => 20 ],
        ];

        DB::table('coupons')->insert($products);
    }
}
