<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorPaletteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_palette', function (Blueprint $table) {
            $table->integer('palette_id')->unsigned();
            $table->integer('color_id')->unsigned();

            $table->foreign('palette_id')
                ->references('id')
                ->on('palettes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['palette_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('color_palette', function(Blueprint $table) {
            $table->dropForeign('color_palette_palette_id_foreign');
            $table->dropForeign('color_palette_color_id_foreign');
        });
        Schema::dropIfExists('color_palette');
    }
}
