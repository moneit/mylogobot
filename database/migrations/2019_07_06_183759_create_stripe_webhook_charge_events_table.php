<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeWebhookChargeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_webhook_charge_events', function (Blueprint $table) {
            $table->string('id')->primary(); // stripe_event_id
            $table->string('type');

            $table->boolean('captured')->nullable();
            $table->string('status')->nullable();

            $table->string('charge_id');
            $table->string('amount');
            $table->string('transaction_id')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('payment_method')->nullable();

            $table->string('dispute_id')->nullable();
            $table->string('dispute_reason')->nullable();

            $table->string('refund_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_webhook_events');
    }
}
