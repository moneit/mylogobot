<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColorCategoryPalette extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_category_palette', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('color_category_id');
            $table->unsignedInteger('palette_id');

            $table->foreign('color_category_id')
                ->references('id')
                ->on('color_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('palette_id')
                ->references('id')
                ->on('palettes')
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
        Schema::table('color_category_palette', function(Blueprint $table) {
            $table->dropForeign('color_category_palette_color_category_id_foreign');
            $table->dropForeign('color_category_palette_palette_id_foreign');
        });
        Schema::dropIfExists('color_category_palette');
    }
}
