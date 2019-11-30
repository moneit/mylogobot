<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palettes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bg_color', 7);
            $table->string('fg_color', 7);
            $table->unsignedInteger('tone_id');

            $table->foreign('tone_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('palettes', function(Blueprint $table) {
            $table->dropForeign('palettes_tone_id_foreign');
        });
        Schema::dropIfExists('palettes');
    }
}
