<?php

namespace App\Http\Resources\Users;

use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFullResource extends JsonResource
{
    public function toArray(Request $request)
    {
        $response = [
            'id' => $this->id,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'is_passed_moderation' => $this->is_passed_moderation,
            'is_banned' => $this->is_banned
        ];

        $role = Role::find($this->role_id)->code;
        if ($role !== 'user') {
            $response["login"] = $this->login;
        }

        $response["role"] = $role;

        return $response;
    }
}
