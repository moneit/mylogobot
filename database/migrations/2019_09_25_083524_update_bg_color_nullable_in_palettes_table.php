<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBgColorNullableInPalettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palettes', function (Blueprint $table) {
            $table->string('bg_color', 7)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('palettes', function (Blueprint $table) {
            $table->string('bg_color', 7)->nullable(false)->change();
        });
    }
}
