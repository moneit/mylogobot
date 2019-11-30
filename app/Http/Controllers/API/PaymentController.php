<?php

namespace App\Http\Controllers\API;

use App\Package;
use App\Coupon;
use App\Order;
use App\Country;
use App\Payment;
use App\Events\ProductPurchased;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Payment\Paypal\PaymentVerifyRequest;
use App\Http\Requests\API\Payment\Stripe\PaymentIntentRequest;
use App\Http\Requests\API\Payment\Stripe\PaymentConfirmRequest;
use App\Services\Payment\Paypal\Client as PaypalClient;
use Mpociot\VatCalculator\VatCalculator;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class PaymentController extends Controller
{
    /**
     * @var VatCalculator
     */
    private $vatCalculator;

    /**
     * @var string
     */
    private $priceUnit;

    public function __construct()
    {
        $this->vatCalculator = new VatCalculator();
        $this->priceUnit = '$';
    }

    public function intent(PaymentIntentRequest $request)
    {
        try {
            /* disable ip / country verification for now
            $countryCode = $this->vatCalculator->getIPBasedCountry();
            if ($countryCode !== $request->get('countryCode')) {
                throw new \Exception('Country code and ip address does not match.');
            }
            */
            $countryCode = $request->get('countryCode');

            $zipcode = $request->get('zipcode');
            $packageId = $request->get('packageId');
            $totalPrice = $request->get('totalPrice');
            $paymentMethod = $request->get('paymentMethod');
            $couponCode = $request->get('couponCode');
            $totalWithCoupon = $request->get('totalWithCoupon');

            $package = Package::findOrFail($packageId);

            $isValidCompany = false;
            if ($request->has('vat')) {
                $isValidCompany = $this->vatCalculator->isValidVATNumber($request->get('vat'));
            }

            $grossPrice = $this->vatCalculator->calculate($package->price, $countryCode, $zipcode, $isValidCompany);
            if ($totalPrice !== number_format($grossPrice, 2)) {
                throw new \Exception('The total price is not matching between front-end and back-end.');
            }

            $vatRate = $this->vatCalculator->getTaxRateForLocation($countryCode, $zipcode, $isValidCompany);
            $vatValue = $vatRate * $package->price;

            if (! empty($couponCode)) {
                $coupon = Coupon::where('code', '=', $couponCode)->first();

                if (! empty($coupon)) {
                    $discount = (float)(number_format((float)$totalPrice / 100.0 * $coupon->discount_rate, 2));
                    $total = (float)$totalPrice - $discount;

                    if (number_format($total, 2) !== $totalWithCoupon) {
                        throw new \Exception('The total price with coupon is not matching between front-end and back-end.');
                    }
                } else {
                    $coupon = null;
                    $total = (float)$totalPrice;
                }
            } else {
                $coupon = null;
                $total = (float)$totalPrice;
            }

            $order = new Order;
            $order->user_id = \Auth::id();
            $order->logo_id = $request->get('logoId');
            $order->package_id = $packageId;
            $order->coupon_id = optional($coupon)->id;
            $order->user_ip = explode('.', $request->ip())[0] * 256 * 256 * 256 + explode('.', $request->ip())[1] * 256 * 256 + explode('.', $request->ip())[2] * 256 + explode('.', $request->ip())[3]; // todo: update
            $order->country_id = Country::where('code', '=', $countryCode)->firstOrFail()->id;
            $order->address = $request->get('address', '');
            $order->city = $request->get('city', '');
            $order->state = $request->get('state', '');
            $order->zipcode = $zipcode;
            $order->vat_number = $request->get('vat', '');;
            $order->vat_rate = $this->vatCalculator->getTaxRateForLocation($countryCode, $zipcode, $isValidCompany);
            $order->price = $total;
            $order->currency = 'USD'; // temporary solution for now
            $order->payment_method = $paymentMethod;

            $order->save();

            if ($total == 0) { // for LB100
                $order->status = 'succeeded';

                $order->save();

                event(new ProductPurchased($order));

                return $this->response([
                    'status' => 'success',
                    'payload' => [
                        'orderId' => $order->id,
                    ]
                ]);
            } else {
                if ($paymentMethod === 'credit_card') {
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $paymentIntent = \Stripe\PaymentIntent::create(
                        [
                            'payment_method' => $request->get('paymentMethodId'),
                            'amount' => $total * 100,
                            'currency' => 'usd',
                            'metadata' => [
                                'order_id' => $order->id,
                                'user_name' => \Auth::user()->name,
                                'user_email' => \Auth::user()->email,
                                'package_name' => $package->name,
                                'package_price' => $package->price . $this->priceUnit,
                                'vat_number' => $request->get('vat', ''),
                                'is_valid_company' => $isValidCompany ? 'yes' : 'no',
                                'vat_rate' => $vatRate,
                                'vat_value' => $vatValue . $this->priceUnit,
                                'coupon_code' => optional($coupon)->code,
                                'coupon_discount_rate' => optional($coupon)->discount_rate ? optional($coupon)->discount_rate . '%' : '',
                                'discount_by_coupon' => !empty($discount) ? $discount . $this->priceUnit : '0' . $this->priceUnit,
                            ],
                            'confirmation_method' => 'manual',
                            'confirm' => true,
                        ],
                        [
                            'idempotency_key' => $request->get('idempotencyKey'),
                        ]
                    );

                    $order->payment_intent_id = $paymentIntent->id; // todo: this is not correct actually
                    $order->status = $paymentIntent->status;

                    $order->save(); // todo: update transaction id and status from webhook

                    if ($paymentIntent->status === 'requires_action' && $paymentIntent->next_action->type === 'use_stripe_sdk') {
                        // tell the client to handle the action
                        return $this->response([
                            'status' => 'success',
                            'payload' => [
                                'requiresAction' => true,
                                'orderId' => $order->id,
                                'paymentIntent' => $paymentIntent,
                            ],
                        ]);
                    } else if ($paymentIntent->status === 'succeeded') {
                        event(new ProductPurchased($order));

                        return $this->response([
                            'status' => 'success',
                            'payload' => [
                                'orderId' => $order->id,
                                'paymentIntent' => $paymentIntent,
                            ]
                        ]);
                    } else {
                        // invalid status
                        return $this->response([
                            'status' => 'failure',
                            'payload' => [
                                'message' => 'Got invalid status in getting payment intent.',
                                'paymentIntent' => $paymentIntent,
                            ],
                        ]);
                    }
                }

                if ($paymentMethod === 'paypal') {
                    return $this->response([
                        'status' => 'success',
                        'payload' => [
                            'orderId' => $order->id,
                        ]
                    ]);
                }
            }
        } catch(\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ]);
        }
    }

    public function confirm(PaymentConfirmRequest $request)
    {
        $order = Order::findOrFail($request->get('orderId'));
        $paymentIntentId = $request->input('paymentIntentId');

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent = $paymentIntent->confirm();

            $order->status = $paymentIntent->status;
            $order->save();

            if ($paymentIntent->status === 'succeeded') {
                return $this->response([
                    'status' => 'success',
                    'payload' => [
                        'orderId' => $order->id,
                        'paymentIntent' => $paymentIntent,
                    ],
                ]);
            } else {
                return $this->response([
                    'status' => 'failure',
                    'payload' => [
                        'message' => 'Payment confirmation failed. Got status of ' . $paymentIntent->status . '.'
                    ],
                ]);
            }
        } catch (\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ]);
        }
    }

    public function verifyPalpalTransaction(PaymentVerifyRequest $request)
    {
        $orderId = $request->get('orderId');
        $paypalOrderId = $request->get('paypalOrderId');

//      3. Call PayPal to get the transaction details
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($paypalOrderId));

        /**
         *Enable the following line to print complete response as JSON.
         */
        $order = Order::findOrFail($orderId);
//        print json_encode($response->result);
//        print "Status Code: {$response->statusCode}\n";
//        print "Status: {$response->result->status}\n";
        $order->status = $response->result->status;
        $order->payment_intent_id = $response->result->id; // paypal order id
        $order->save();
//        print "Order ID: {$response->result->id}\n";
//        print "Intent: {$response->result->intent}\n";
//        print "Links:\n";
//        foreach($response->result->links as $link)
//        {
//            print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
//        }
//        Save the transaction in your database. Implement logic to save transaction to your database for future reference.
//        print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";
        $payment = new Payment;

        $payment->order_id = $orderId;
        $payment->amount = $response->result->purchase_units[0]->amount->value;
        $payment->currency = $response->result->purchase_units[0]->amount->currency_code;
        $payment->save();

        return $this->response([
            'status' => 'success',
            'payload' => [
                'orderId' => $orderId,
                'result' => $response->result
            ],
        ]);
//        To print the whole response body, uncomment the following line
//        echo json_encode($response->result, JSON_PRETTY_PRINT);
    }
}
