<?php

namespace App\Http\Requests\API\ColorPalette;

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
            'color_id' => ['required', 'exists:colors,id'],
            'palette_id' => ['required', 'exists:palettes,id'],
        ];
    }
}
