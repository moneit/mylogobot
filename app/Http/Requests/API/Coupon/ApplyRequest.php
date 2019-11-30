<?php

namespace App\Http\Requests\API\Coupon;

use App\Http\Requests\API\ApiRequest;

class ApplyRequest extends ApiRequest
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
            'code' => ['required', 'exists:coupons,code'],
            'total' => ['required', 'numeric'],
        ];
    }
}
