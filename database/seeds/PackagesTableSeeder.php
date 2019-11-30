<?php

use Illuminate\Database\Seeder;
use App\Package;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->delete();

        $products = [
            [ 'name' => Package::basicPackageName, 'price' => Package::basicPackagePrice ],
            [ 'name' => Package::premiumPackageName, 'price' => Package::premiumPackagePrice ],
            [ 'name' => Package::enterprisePackageName, 'price' => Package::enterprisePackagePrice ],
        ];

        DB::table('packages')->insert($products);
    }
}
