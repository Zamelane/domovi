<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;

class LoginUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'sms_token' => 'required|string|min:8',
            'code' => 'required|string|min:6|max:6'
        ];
    }
}
