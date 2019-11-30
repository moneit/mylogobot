<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color_1', 7);
            $table->string('color_2', 7);
            $table->string('color_3', 7);
            $table->string('color_4', 7);
            $table->string('color_5', 7);
            $table->string('color_6', 7);
            $table->string('color_7', 7);
            $table->string('color_8', 7);
            $table->string('color_9', 7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_categories');
    }
}
