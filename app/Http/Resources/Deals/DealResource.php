<?php

namespace App\Http\Resources\Deals;

use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "client" => UserResource::make($this->user),
            "owner" => UserResource::make($this->advertisement->user),
            "agent" => UserResource::make($this->employee),
            "deal_status" => $this->deal_status,
            "advertisement_id" => $this->advertisement_id,
            "percent" => $this->percent,
            "create_date" => $this->create_date,
            "start_date" => $this->start_date,
            "valid_until_date" => $this->valid_until_date,
            "address" => AddressResource::make($this->address)
        ];
    }
}
