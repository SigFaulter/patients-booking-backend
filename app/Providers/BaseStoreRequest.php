<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class BaseStoreRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['error' => true, $validator->errors()], 422));
    }
}
