<?php

namespace App\Http\Requests\API;


class FreeDownloadRequest extends ApiRequest
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
            'logoId' => ['required', 'regex:/^[1-9]\d*$/i',], // positive integer
        ];
    }
}
