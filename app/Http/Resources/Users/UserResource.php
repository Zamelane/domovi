<?php

namespace App\Http\Resources\Users;

use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'phone' => $this->phone,
            'full_name' => $this->full_name()
        ];

        $role = Role::find($this->role_id)->code;
        if ($role !== 'user' && $role !== 'owner') {
            $response["login"] = $this->login;
        }

        $response["role"] = $role;

        return $response;
    }
}
