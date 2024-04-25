<?php

namespace App\Http\Resources\Users;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->first_name,
            'middle_name' => $this->middle_name
        ];

        $role = Role::find($this->role_id)->code;
        if ($role !== 'user') {
            $response["login"] = $this->login;
            $response["password"] = $this->password;
        }

        $response["role"] = $role;

        return $response;
    }
}
