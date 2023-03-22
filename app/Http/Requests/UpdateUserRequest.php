<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseStoreRequest;

class UpdateUserRequest extends BaseStoreRequest
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
        $id = $this->route('id');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ];
    }

}
