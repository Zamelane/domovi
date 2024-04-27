<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends ApiRequest
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
