<?php

namespace App\Http\Controllers;

use App\Events\ProductPurchased;
use App\Order;
use App\StripeWebhookChargeEvent;
use App\StripeWebhookPaymentIntentEvent;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Event;

class StripeWebhookController extends WebhookController
{
    /**
     * Handle a Stripe webhook call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $idempotent = StripeWebhookChargeEvent::find($payload['id']);

        if (is_null($idempotent)) {
            switch($payload['type']) { // https://stripe.com/docs/api/events/types#event_types-charge.captured
                case Event::CHARGE_CAPTURED:
                case Event::CHARGE_EXPIRED:
                case Event::CHARGE_FAILED:
                case Event::CHARGE_PENDING:
                case Event::CHARGE_REFUNDED:
                case Event::CHARGE_SUCCEEDED:
                case Event::CHARGE_UPDATED: // description or metadata updated, no use for now
                    $stripeWebhookChargeEvent = new StripeWebhookChargeEvent;

                    $stripeWebhookChargeEvent->id = $payload['id'];
                    $stripeWebhookChargeEvent->type = $payload['type'];

                    $stripeWebhookChargeEvent->captured = $payload['data']['object']['captured'];
                    $stripeWebhookChargeEvent->status = $payload['data']['object']['status'];

                    $stripeWebhookChargeEvent->charge_id = $payload['data']['object']['id'];
                    $stripeWebhookChargeEvent->amount = $payload['data']['object']['amount'];
                    $stripeWebhookChargeEvent->transaction_id = $payload['data']['object']['balance_transaction'];
//                    $stripeWebhookChargeEvent->currency = $payload['data']['currency']; // for now only USD is supported
                    $stripeWebhookChargeEvent->payment_method = $payload['data']['object']['payment_method'];

                    $stripeWebhookChargeEvent->save();
                    break;
                case Event::CHARGE_DISPUTE_CLOSED:
                case Event::CHARGE_DISPUTE_CREATED:
                case Event::CHARGE_DISPUTE_FUNDS_REINSTATED:
                case Event::CHARGE_DISPUTE_FUNDS_WITHDRAWN:
                case Event::CHARGE_DISPUTE_UPDATED:
                    $stripeWebhookChargeEvent = new StripeWebhookChargeEvent;

                    $stripeWebhookChargeEvent->id = $payload['id'];
                    $stripeWebhookChargeEvent->type = $payload['type'];

                    $stripeWebhookChargeEvent->status = $payload['data']['object']['status'];

                    $stripeWebhookChargeEvent->charge_id = $payload['data']['object']['charge'];
                    $stripeWebhookChargeEvent->amount = $payload['data']['object']['amount'];
                    $stripeWebhookChargeEvent->transaction_id = $payload['data']['object']['balance_transaction'];
//                    $stripeWebhookChargeEvent->currency = $payload['data']['currency']; // for now only USD is supported
                    $stripeWebhookChargeEvent->dispute_id = $payload['data']['object']['id'];
                    $stripeWebhookChargeEvent->dispute_reason = $payload['data']['object']['reason'];

                    $stripeWebhookChargeEvent->save();
                    break;
                case Event::CHARGE_REFUND_UPDATED:
                    $stripeWebhookChargeEvent = new StripeWebhookChargeEvent;

                    $stripeWebhookChargeEvent->id = $payload['id'];
                    $stripeWebhookChargeEvent->type = $payload['type'];

                    $stripeWebhookChargeEvent->status = $payload['data']['object']['status'];

                    $stripeWebhookChargeEvent->charge_id = $payload['data']['object']['charge'];
                    $stripeWebhookChargeEvent->amount = $payload['data']['object']['amount'];
                    $stripeWebhookChargeEvent->transaction_id = $payload['data']['object']['balance_transaction'];
//                    $stripeWebhookChargeEvent->currency = $payload['data']['currency']; // for now only USD is supported
                    $stripeWebhookChargeEvent->refund_id = $payload['data']['object']['id'];

                    $stripeWebhookChargeEvent->save();
                    break;
            }

            switch($payload['type']) { // https://stripe.com/docs/api/events/types#event_types-payment_intent.amount_capturable_updated
                case Event::PAYMENT_INTENT_AMOUNT_CAPTURABLE_UPDATED: // Occurs when a PaymentIntent has funds to be captured. Check the amount_capturable property on the PaymentIntent to determine the amount that can be captured. You may capture the PaymentIntent with an amount_to_capture value up to the specified amount. Learn more about capturing PaymentIntents.
                case Event::PAYMENT_INTENT_CREATED: // Occurs when a new PaymentIntent is created.
                case Event::PAYMENT_INTENT_PAYMENT_FAILED: // Occurs when a PaymentIntent has failed the attempt to create a source or a payment.
                case Event::PAYMENT_INTENT_SUCCEEDED: // Occurs when a PaymentIntent has been successfully fulfilled.
                    $stripeWebhookPaymentIntentEvent = new StripeWebhookChargeEvent;

                    $stripeWebhookPaymentIntentEvent->id = $payload['id'];
                    $stripeWebhookPaymentIntentEvent->type = $payload['type'];
                    $stripeWebhookPaymentIntentEvent->status = $payload['data']['object']['status'];

                    $stripeWebhookPaymentIntentEvent->save();
                    break;
            }
        }

        switch($payload['type']) {
            case Event::CHARGE_SUCCEEDED:
                $paymentIntent = $payload['data']['object']['payment_intent'];

                $order = Order::where('payment_intent_id', '=', $paymentIntent)->firstOrFail();
                if ($order->status !== 'succeeded') {
                    $order->status = 'succeeded';

                    event(new ProductPurchased($order));
                }
                $order->save();
        }

        return response([
            'idempotent' => !is_null($idempotent)
        ], 200);
    }
}
