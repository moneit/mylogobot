<?php

namespace App\Http\Requests\API\Payment\Paypal;

use App\Http\Requests\API\ApiRequest;

class PaymentVerifyRequest extends ApiRequest
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
            'orderId' => ['required', 'exists:orders,id'],
            'paypalOrderId' => ['required', 'string'], // todo: add more specific validation
        ];
    }
}