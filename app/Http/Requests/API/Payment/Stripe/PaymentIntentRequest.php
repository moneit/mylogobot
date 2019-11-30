<?php

namespace App\Http\Requests\API\Payment\Stripe;

use App\Http\Requests\API\ApiRequest;

class PaymentIntentRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => ['string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'zipcode' => ['nullable', 'string'],
            'vat' => ['nullable', 'string'],
            'packageId' => ['required', 'exists:packages,id'],
            'logoId' => ['required', 'exists:logos,id'],
            'countryCode' => ['required', 'exists:countries,code'],
            'totalPrice' => ['required', 'numeric'],
            'paymentMethod' => ['required', 'in:credit_card,paypal'],
//            'couponCode' => ['nullable', 'exists:coupons,code'], // coupon code can be wrong, coupon does not apply in that case
            'totalWithCoupon' => ['required', 'numeric'],
            'idempotencyKey' => ['required', 'string'], // todo: add more specific validation
            'paymentMethodId' => ['sometimes', 'required', 'string'], // todo: add more specific validation
        ];
    }
}
