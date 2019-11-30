<?php

namespace App\Http\Requests\API\Palette;

use App\Http\Requests\API\ApiRequest;

class StoreRequest extends ApiRequest
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
            'bg_color' => ['nullable'],// todo: hex (#dddddd) validation
            'company_name_color' => ['required'],// todo: hex (#dddddd) validation
            'slogan_color' => ['required'],// todo: hex (#dddddd) validation
            'symbol_color' => ['required'],// todo: hex (#dddddd) validation
        ];
    }
}
