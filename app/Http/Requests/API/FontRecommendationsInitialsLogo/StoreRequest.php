<?php

namespace App\Http\Requests\API\FontRecommendationsInitialsLogo;

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
            'initials_font_id' => ['required', 'exists:fonts,id'],
            'company_name_font_id' => ['required', 'exists:fonts,id'],
            'slogan_font_id' => ['required', 'exists:fonts,id'],
        ];
    }
}
