<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = [
            [ 'name' => Role::$system['ADMIN'] ],
            [ 'name' => Role::$system['SUPER_ADMIN'] ],
            [ 'name' => Role::$system['DEVELOPER'] ],
        ];

        DB::table('roles')->insert($roles);
    }
}
