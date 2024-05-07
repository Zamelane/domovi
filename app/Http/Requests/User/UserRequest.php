<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'first_name'            => 'string|min:3|max:30',
            'last_name'             => 'string|min:3|max:30',
            'patronymic'            => 'string|min:3|max:30',
            'phone'                 => 'string|min:2|max:15',
            'role'                  => 'exists:roles,code',
            'is_employee'           => 'boolean',
            'is_passed_moderation'  => 'boolean',
            'is_banned'             => 'boolean'
        ];
    }
}
