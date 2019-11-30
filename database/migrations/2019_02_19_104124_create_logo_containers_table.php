<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogoContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_containers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('logo_id');
            $table->unsignedInteger('container_id');
            $table->integer('size'); // 0 to 100
            $table->string('color_hex', 7);
            $table->float('color_opacity');
            $table->timestamps();

            $table->foreign('logo_id')
                ->references('id')
                ->on('logos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('container_id')
                ->references('id')
                ->on('containers')
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
        Schema::table('logo_containers', function(Blueprint $table) {
            $table->dropForeign('logo_containers_logo_id_foreign');
            $table->dropForeign('logo_containers_container_id_foreign');
        });
        Schema::dropIfExists('logo_containers');
    }
}
