<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaletteTableReplaceFgWithCompanyNameAndSloganAndSymbol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palettes', function(Blueprint $table) {
            $table->dropColumn('fg_color');

            $table->dropForeign('palettes_tone_id_foreign');
            $table->dropColumn('tone_id');

            $table->string('company_name_color', 7);
            $table->string('slogan_color', 7);
            $table->string('symbol_color', 7);
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
            $table->dropColumn('company_name_color', 7);
            $table->dropColumn('slogan_color', 7);
            $table->dropColumn('symbol_color', 7);

            $table->string('fg_color');
            $table->unsignedInteger('tone_id');

            $table->foreign('tone_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
