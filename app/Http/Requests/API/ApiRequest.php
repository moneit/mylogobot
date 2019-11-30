<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\StringEncodeDecodeService;

class ApiRequest extends FormRequest
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
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
//        throw new HttpResponseException(response()->json(StringEncodeDecodeService::encode(json_encode([
        throw new HttpResponseException(response()->json([
            'status' => 'failure',
            'payload' => [
                'message' => $validator->errors()->all()[0]
            ]
        ], 200));
    }
}
