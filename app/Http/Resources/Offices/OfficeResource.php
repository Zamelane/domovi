<?php

namespace App\Http\Resources\Offices;

use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Days\DayResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "work_days" => DayResource::collection($this->days),
            "is_active" => $this->is_active,
            "address" => AddressResource::make($this->address)
        ];
    }
}
