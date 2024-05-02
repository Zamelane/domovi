<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class UserEditRequest extends ApiRequest
{
    public function rules(): array
    {
        $currId = $this->id ?? auth()->user()->id;
        return [
            'first_name'    => 'string|min:3|max:32',
            'last_name'     => 'string|min:3|max:32',
            'patronymic'    => 'string|min:3|max:32',
            'phone'         => 'integer|unique:users,phone,'.$currId,
            'login'         => 'string|unique:users,login,'.$currId,
            'password'      => 'string|min:6|max:50',
            'role'          => 'string|exists:roles,code',
            'is_moderated'  => 'boolean',
            'is_banned'     => 'boolean'
        ];
    }
}
