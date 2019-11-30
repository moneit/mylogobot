<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('company_name');
            $table->string('slogan');
            $table->string('details'); // join keywords by space
            $table->timestamps();

            $table->foreign('user_id', 'rt_user_id_foreign')
                ->references('id')
                ->on('users')
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
        Schema::table('recommendation_tracks', function(Blueprint $table) {
            $table->dropForeign('rt_user_id_foreign');
        });

        Schema::dropIfExists('recommendation_tracks');
    }
}
