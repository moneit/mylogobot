<?php

namespace App\Http\Requests\API\Order;

use App\Http\Requests\API\ApiRequest;

class CreateRequest extends ApiRequest
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
            'packageId' => ['required', 'exists:packages,id'],
            'logoId' => ['required', 'exists:logos,id'],
            'countryCode' => ['required', 'exists:countries,code'],
        ];
    }
}
