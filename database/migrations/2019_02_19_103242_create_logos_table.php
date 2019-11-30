<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bg_color', 7)->nullable();
            $table->string('layout');
            $table->float('scale')->default(1.0);
            $table->longText('svg');
            $table->longText('symbol_only_svg');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::table('logos', function(Blueprint $table) {
            $table->dropForeign('logos_user_id_foreign');
        });
        Schema::dropIfExists('logos');
    }
}
