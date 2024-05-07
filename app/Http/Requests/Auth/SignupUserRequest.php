<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class SignupUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string|min:3|max:32',
            'last_name'     => 'required|string|min:3|max:32',
            'patronymic'    => 'string|min:3|max:32',
            'phone'         => 'required|integer|unique:users',
            'role'          => 'in:owner,user',
            'sms_token'     => 'string|min:8',
            'code'          => 'string|min:6|max:6'
        ];
    }
}
