<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|min:8|max:255',
            'image' => 'sometimes|string',
        ];
    }

}
