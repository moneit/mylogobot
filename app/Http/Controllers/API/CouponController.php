<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Coupon;
use App\Http\Requests\API\Coupon\ApplyRequest as CouponApplyRequest;

class CouponController extends Controller
{
    public function apply(CouponApplyRequest $request)
    {
        try {
            $code = $request->get('code');
            $total = $request->get('total');

            $coupon = Coupon::where('code', '=', $code)->firstOrFail();

            return $this->response([
                'status' => 'success',
                'payload' => [
                    'code' => $code,
                    'discount' => number_format((float)$total / 100.0 * $coupon->discount_rate, 2),
                ],
            ]);
        } catch(\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ]);
        }
    }
}
