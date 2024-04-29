<?php

namespace App\Http\Resources\Advertisements;

use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Filters\FilterResource;
use App\Http\Resources\Images\ImageResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementMinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = [
            "id"               => $this->id,
            "address"          => AddressResource::make($this->address),
            "type"             => $this->advertisement_type,
            "transaction_type" => $this->transaction_type,
            "detailed" => [
                "area"             => $this->area,
                "count_rooms"      => $this->count_rooms,
                "measurement_type" => $this->measurement_type,
                "images"           => ImageResource::collection($this->photos)
            ],
            "filters"          => FilterResource::collection($this->ad_filter_values),
            "cost"             => $this->cost
        ];

        return $response;
    }
}
