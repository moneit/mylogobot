<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFontRecommendationsInitialsLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('font_recommendations_initials_logos', function (Blueprint $table) {
            $table->integer('initials_font_id')->unsigned();
            $table->integer('company_name_font_id')->unsigned();
            $table->integer('slogan_font_id')->unsigned();

            $table->foreign('initials_font_id', 'initials_logos_initials_font_id_foreign')
                ->references('id')
                ->on('fonts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('company_name_font_id', 'initials_logos_company_name_font_id_foreign')
                ->references('id')
                ->on('fonts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('slogan_font_id', 'initials_logos_slogan_font_id_foreign')
                ->references('id')
                ->on('fonts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['initials_font_id', 'company_name_font_id', 'slogan_font_id'], 'primary_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('font_recommendations_initials_logos', function(Blueprint $table) {
            $table->dropForeign('font_recommendations_initials_logos_initials_font_id_foreign');
            $table->dropForeign('font_recommendations_initials_logos_company_name_font_id_foreign');
            $table->dropForeign('font_recommendations_initials_logos_slogan_font_id_foreign');
        });
        Schema::dropIfExists('font_recommendations_initials_logos');
    }
}
