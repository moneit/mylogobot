<?php

namespace App\Http\Requests\API\ColorCategoryPalette;

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
            'color_category_id' => ['required', 'exists:color_categories,id'],
            'palette_id' => ['required', 'exists:palettes,id'],
        ];
    }
}
