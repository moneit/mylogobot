<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogoSlogansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_slogans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('logo_id');
            $table->unsignedInteger('font_id');
            $table->string('text');
            $table->integer('font_size'); // 0 to 100
            $table->integer('letter_space'); // 0 to 100
            $table->integer('line_space'); // 0 to 100
            $table->string('color_hex', 7);
            $table->float('color_opacity');
            $table->string('capitalization')->nullable();
            $table->timestamps();

            $table->foreign('logo_id')
                ->references('id')
                ->on('logos')
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
        Schema::table('logo_slogans', function(Blueprint $table) {
            $table->dropForeign('logo_slogans_logo_id_foreign');
        });
        Schema::dropIfExists('logo_slogans');
    }
}
