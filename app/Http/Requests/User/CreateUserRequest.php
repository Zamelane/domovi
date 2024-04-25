<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string|min:3|max:32',
            'last_name'     => 'required|string|min:3|max:32',
            'patronymic'    => 'required|string|min:3|max:32',
            'phone'         => 'required|integer|unique:users',
            'role'          => 'string|exists:roles,code',
            'is_moderated'  => 'boolean'
        ];
    }
}
