<?php

use Illuminate\Database\Seeder;

class ContainersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('containers')->delete();
        $fonts = array(
            array('file_name' => 'container-logobot (1).svg',       'filled' => false),
            array('file_name' => 'container-logobot (2).svg',       'filled' => false),
            array('file_name' => 'container-logobot (3).svg',       'filled' => false),
            array('file_name' => 'container-logobot (4).svg',       'filled' => true),
            array('file_name' => 'container-logobot (5).svg',       'filled' => true),
            array('file_name' => 'container-logobot (6).svg',       'filled' => true),
            array('file_name' => 'container-logobot (7).svg',       'filled' => true),
            array('file_name' => 'container-logobot (8).svg',       'filled' => true),
            array('file_name' => 'container-logobot (9).svg',       'filled' => true),
            array('file_name' => 'container-logobot (10).svg',      'filled' => true),
            array('file_name' => 'container-logobot (11).svg',      'filled' => false),
            array('file_name' => 'container-logobot (12).svg',      'filled' => false),
            array('file_name' => 'container-logobot (13).svg',      'filled' => false),
            array('file_name' => 'container-logobot (14).svg',      'filled' => true),
            array('file_name' => 'container-logobot (15).svg',      'filled' => true),
            array('file_name' => 'container-logobot (16).svg',      'filled' => true),
            array('file_name' => 'container-logobot (17).svg',      'filled' => true),
            array('file_name' => 'container-logobot (18).svg',      'filled' => true),
            array('file_name' => 'container-logobot (19).svg',      'filled' => true),
            array('file_name' => 'container-logobot (20).svg',      'filled' => true),
            array('file_name' => 'container-logobot (21).svg',      'filled' => false),
            array('file_name' => 'container-logobot (22).svg',      'filled' => false),
            array('file_name' => 'container-logobot (23).svg',      'filled' => false),
            array('file_name' => 'container-logobot (24).svg',      'filled' => false),
            array('file_name' => 'container-logobot (25).svg',      'filled' => false),
            array('file_name' => 'container-logobot (26).svg',      'filled' => false),
            array('file_name' => 'container-logobot (27).svg',      'filled' => false),
            array('file_name' => 'container-logobot (28).svg',      'filled' => false),
            array('file_name' => 'container-logobot (29).svg',      'filled' => true),
            array('file_name' => 'container-logobot (30).svg',      'filled' => true),
            array('file_name' => 'container-logobot (31).svg',      'filled' => true),
            array('file_name' => 'container-logobot (32).svg',      'filled' => true),
            array('file_name' => 'container-logobot (33).svg',      'filled' => true),
            array('file_name' => 'container-logobot (34).svg',      'filled' => true),
            array('file_name' => 'container-logobot (35).svg',      'filled' => true),
            array('file_name' => 'container-logobot (36).svg',      'filled' => true),
            array('file_name' => 'container-logobot (37).svg',      'filled' => true),
            array('file_name' => 'container-logobot (38).svg',      'filled' => true),
            array('file_name' => 'container-logobot (39).svg',      'filled' => true),
            array('file_name' => 'container-logobot (40).svg',      'filled' => true),
            array('file_name' => 'container-logobot (41).svg',      'filled' => true),
            array('file_name' => 'container-logobot (42).svg',      'filled' => false),
            array('file_name' => 'container-logobot (43).svg',      'filled' => true),
            array('file_name' => 'container-logobot (44).svg',      'filled' => true),
            array('file_name' => 'container-logobot (45).svg',      'filled' => false),
            array('file_name' => 'container-logobot (46).svg',      'filled' => false),
            array('file_name' => 'container-logobot (47).svg',      'filled' => false),
            array('file_name' => 'container-logobot (48).svg',      'filled' => true),
            array('file_name' => 'container-logobot (49).svg',      'filled' => true),
            array('file_name' => 'container-logobot (50).svg',      'filled' => true),
            array('file_name' => 'container-logobot (51).svg',      'filled' => true),
            array('file_name' => 'container-logobot (52).svg',      'filled' => true),
            array('file_name' => 'container-logobot (53).svg',      'filled' => true),
            array('file_name' => 'container-logobot (54).svg',      'filled' => true),
        );
        DB::table('containers')->insert($fonts);
    }
}
