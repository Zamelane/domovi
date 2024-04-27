<?php

namespace App\Http\Resources\Streets;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "street_id" => $this->id,
            "street_name" => $this->name,
            "city_id" => $this->city->id,
            "city_name" => $this->city->name
        ];
    }
}
