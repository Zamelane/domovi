<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;

class LoginUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|min:6|max:15'
        ];
    }
}
