<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('logo_id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('coupon_id')->nullable();
            $table->unsignedInteger('user_ip'); // inet_pton
            $table->unsignedInteger('country_id');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('zipcode')->nullable();
            $table->float('vat_rate'); // todo: check if decimal:2 or whatever
            $table->decimal('price', 13, 2); // todo: check if decimal:2 or whatever
            $table->char('currency', 3);
            $table->string('payment_method');
            $table->string('charge_id')->nullable();
            $table->string('status')->nullable();
            $table->string('file_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('logo_id')
                ->references('id')
                ->on('logos');

            $table->foreign('package_id')
                ->references('id')
                ->on('packages');

            $table->foreign('coupon_id')
                ->references('id')
                ->on('coupons');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');

            $table->foreign('currency')
                ->references('iso_code')
                ->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_logo_id_foreign');
            $table->dropForeign('orders_package_id_foreign');
            $table->dropForeign('orders_coupon_id_foreign');
            $table->dropForeign('orders_country_id_foreign');
            $table->dropForeign('orders_currency_foreign');
        });
        Schema::dropIfExists('orders');
    }
}
