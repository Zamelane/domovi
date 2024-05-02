<?php

namespace App\Http\Resources\Streets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "city" => [
                "id" => $this->city->id,
                "name" => $this->city->name
            ]
        ];
    }
}
