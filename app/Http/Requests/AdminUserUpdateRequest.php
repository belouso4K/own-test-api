<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserUpdateRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->id,
            'password' => 'string|min:6',
            'confirm_password' => 'required_with:password|same:password',
            'role_id' => $this->role_id == '' ? '' : 'sometimes|exists:roles,id',
            'avatar' => $this->hasFile('avatar') ? 'mimes:jpeg,jpg,png,gif|max:1024' : '', // 1 MB'
        ];
    }
}
