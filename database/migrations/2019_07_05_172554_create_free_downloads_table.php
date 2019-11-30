<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_downloads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('logo_id')->unsigned();
            $table->integer('count')->unsigned()->default(0);
            $table->string('file_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('logo_id')
                ->references('id')
                ->on('logos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_downloads', function(Blueprint $table) {
            $table->dropForeign('free_downloads_user_id_foreign');
            $table->dropForeign('free_downloads_logo_id_foreign');
        });
        Schema::dropIfExists('free_downloads');
    }
}
