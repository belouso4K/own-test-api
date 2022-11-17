<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleUpdateRequest extends FormRequest
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
            'name' => "required|string|min:3|max:255|unique:roles,name,".$this->role->id,
            'desc' => 'max:255',
            'new_user' => 'sometimes',
            'new_user.*.name' => 'required_with:new_user|string|min:2',
            'new_user.*.email' => 'required_with:new_user|email|max:255|unique:users',
            'new_user.*.password' => 'required_with:new_user|string|min:6',
            'new_user.*.avatar' => 'sometimes|required_with:new_user|mimes:jpeg,jpg,png,gif|max:1024', // 1 MB'
        ];
    }
}
