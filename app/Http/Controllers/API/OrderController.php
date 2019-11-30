<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Order;
use App\Jobs\Product\GenerateProductForOrderAndSendDownloadLinkMail;
use App\Jobs\Product\GenerateProductForOrderAndSendResendFilesMail;
use App\Services\ProductService;
use App\Jobs\Mail\SendResendFilesMail;
use App\Http\Requests\API\Order\CreateRequest;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('current_page', 1);
            $columns = ['*'];
            $pageName = 'page';

            $orderColumn = $request->get('order_column', 'created_at');
            $orderDirection = $request->get('order_direction', 'asc');

            $email = $request->get('email', '');
            $country = $request->get('country', '');
            $package = $request->get('package', '');

            $orders = Order::with(['user:id,email', 'country:id,name', 'package:id,name', 'currencySymbol'])
                ->whereHas('user', function($query) use ($email) { $query->where('email', 'like', '%' . $email . '%'); })
                ->whereHas('country', function($query) use ($country) { $query->where('name', 'like', '%' . $country . '%'); })
                ->whereHas('package', function($query) use ($package) { $query->where('name', 'like', '%' . $package . '%'); })
                ->orderBy($orderColumn, $orderDirection)
                ->select(['id', 'created_at', 'user_id', 'country_id', 'package_id', 'price', 'currency', 'status'])
                ->paginate($perPage, $columns, $pageName, $page);
        } catch (\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ], 200);
        }

        return $this->response([
            'status' => 'success',
            'payload' => $orders,
        ], 200);
    }

    public function getDetails(Request $request)
    {
        try {
            $orderId = $request->get('id');

            $order = Order::with(['logo:id,svg', 'package:id,name', 'user:id,name,email', 'country:id,name'])
                ->select(['id', 'logo_id', 'package_id', 'user_id', 'country_id', 'address', 'city', 'state', 'zipcode', 'vat_number', 'status', 'payment_intent_id', 'price', 'payment_method'/*, 'card'*/])
                ->findOrFail($orderId);

            return $this->response([
                'status' => 'success',
                'payload' => $order,
            ], 200);
        } catch(\Exception $e) {

            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ], 200);
        }
    }

    public function getGenDownloadLink(Order $order)
    {
        try {
            if (!\Auth::user()->isAdmin()) {
                if (\Auth::id() !== $order->user_id) {
                    throw new \Exception('You are not the owner of the order!');
                }
                if ($order->status !== 'succeeded') {
                    throw new \Exception('The order is not purchased yet!');
                }
            }
            if (! empty($order->file_id)) {

                return $this->response([
                    'status' => 'success',
                    'payload' => [
                        'downloadLink' => ProductService::generateDownloadLink($order->logo_id, $order->file_id),
                    ],
                ], 200);
            } else {
                GenerateProductForOrderAndSendDownloadLinkMail::dispatch($order);
//                GenerateProductForOrder::withChain([
//                    new SendDownloadLinkMail($order->id),
//                ])->dispatch($order);

                return $this->response([
                    'status' => 'success',
                    'payload' => [
                        'message' => 'The product is still being generated now. You will get download link in email once it is done.',
                    ],
                ], 200);
            }
        } catch(\Exception $e) {

            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ], 200);
        }
    }

    public function resend(Order $order)
    {
        if (! empty($order->file_id)) {
            dispatch(new SendResendFilesMail($order));

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'message' => 'Resend files mail sent!',
                ],
            ], 200);
        } else {
            GenerateProductForOrderAndSendResendFilesMail::dispatch($order);
//            GenerateProductForOrder::withChain([
//                new SendResendFilesMail($order),
//            ])->dispatch($order);

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'message' => 'The product is still being generated now. It will be resent in email once it is done.',
                ],
            ], 200);
        }
    }

    public function create(CreateRequest $request)
    {
        $order = new Order;
        $order->user_id = \Auth::id();
        $order->logo_id = $request->get('logoId');
        $order->package_id = $request->get('packageId');
        $order->user_ip = explode('.', $request->ip())[0] * 256 * 256 * 256 + explode('.', $request->ip())[1] * 256 * 256 + explode('.', $request->ip())[2] * 256 + explode('.', $request->ip())[3]; // todo: update
        $order->country_id = Country::where('code', '=', $request->get('countryCode'))->firstOrFail()->id;
        $order->vat_rate = 0;
        $order->price = 0;
        $order->currency = 'USD';
        $order->payment_method = 'NONE';

        $order->save();

        return $this->response([
            'status' => 'success',
            'payload' => [
                'order' => $order,
            ],
        ], 200);
    }
}
