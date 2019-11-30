<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogoIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_icons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('logo_id');
            $table->json('tags');
            $table->smallInteger('min_x');
            $table->smallInteger('min_y');
            $table->smallInteger('max_x');
            $table->smallInteger('max_y');
            $table->string('clip_rule', 10)->nullable();
            $table->string('fill_rule', 10)->nullable();
            $table->integer('size'); // 0 to 100
            $table->integer('line_space'); // 0 to 100
            $table->string('color_hex', 7);
            $table->float('color_opacity');
            $table->boolean('hidden');
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
        Schema::table('logo_icons', function(Blueprint $table) {
            $table->dropForeign('logo_icons_logo_id_foreign');
        });
        Schema::dropIfExists('logo_icons');
    }
}
