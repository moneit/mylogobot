<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSendgridContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sendgrid_contact', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->unique();
            $table->string('sendgrid_contact_id')->unique();
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
        Schema::table('user_sendgrid_contact', function(Blueprint $table) {
            $table->dropForeign('user_sendgrid_contact_user_id_foreign');
        });
        Schema::dropIfExists('user_sendgrid_contact');
    }
}
