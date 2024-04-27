<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'    => 'string|min:3|max:32',
            'last_name'     => 'string|min:3|max:32',
            'patronymic'    => 'string|min:3|max:32',
            'phone'         => 'integer|unique:users',
            'login'         => 'string|unique:users',
            'password'      => 'string|min:6|max:50',
            'role'          => 'string|exists:roles,code',
            'is_moderated'  => 'boolean',
            'is_banned'     => 'boolean'
        ];
    }
}
