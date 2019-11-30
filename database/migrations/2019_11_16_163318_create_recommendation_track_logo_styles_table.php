<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTrackLogoStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_track_logo_styles', function (Blueprint $table) {
            $table->integer('recommendation_track_id')->unsigned();
            $table->integer('logo_style_id')->unsigned();

            $table->foreign('recommendation_track_id', 'rtls_recommendation_track_id_foreign')
                ->references('id')
                ->on('recommendation_tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('logo_style_id', 'rtls_logo_style_id_foreign')
                ->references('id')
                ->on('logo_styles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['recommendation_track_id', 'logo_style_id'], 'rtls_tid_lsid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommendation_track_logo_styles', function(Blueprint $table) {
            $table->dropForeign('rtls_recommendation_track_id_foreign');
            $table->dropForeign('rtls_logo_style_id_foreign');
        });

        Schema::dropIfExists('recommendation_track_logo_styles');
    }
}
