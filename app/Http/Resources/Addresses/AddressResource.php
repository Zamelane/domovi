<?php

namespace App\Http\Resources\Addresses;

use App\Http\Resources\Streets\StreetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "house" => $this->house,
            "structure" =>$this->structure,
            "building" => $this->building,
            "apartament" => $this->apartament,
            "street" => StreetResource::make($this->street)
        ];
    }
}
