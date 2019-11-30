<?php

namespace App\Http\Requests\API;


class RecommendationRequest extends ApiRequest
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
            'paletteCategoriesIds' => ['array', ],
            'companyDetails' => ['required', 'string', ],
            'companyName' => ['required', 'string', ],
            'layout' => ['array', ],
            'slogan' => [],
        ];
    }
}
