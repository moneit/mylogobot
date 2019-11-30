<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTrackColorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_track_color_categories', function (Blueprint $table) {
            $table->integer('recommendation_track_id')->unsigned();
            $table->integer('color_category_id')->unsigned();

            $table->foreign('recommendation_track_id', 'rtcc_categories_recommendation_track_id_foreign')
                ->references('id')
                ->on('recommendation_tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('color_category_id', 'rtcc_color_category_id_foreign')
                ->references('id')
                ->on('color_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['recommendation_track_id', 'color_category_id'], 'rtcc_tid_ccid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommendation_track_color_categories', function(Blueprint $table) {
            $table->dropForeign('rtcc_categories_recommendation_track_id_foreign');
            $table->dropForeign('rtcc_color_category_id_foreign');
        });

        Schema::dropIfExists('recommendation_track_color_categories');
    }
}
