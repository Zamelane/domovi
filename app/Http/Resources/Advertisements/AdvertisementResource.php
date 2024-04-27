<?php

namespace App\Http\Resources\Advertisements;

use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Filters\FilterResource;
use App\Http\Resources\Images\ImageResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = [
            "id"               => $this->id,
            "address"          => AddressResource::make($this->address),
            "owner"            => UserResource::make($this->user),
            "type"             => $this->advertisement_type,
            "transaction_type" => $this->transaction_type,
            "detailed" => [
                "area"             => $this->area,
                "count_rooms"      => $this->count_rooms,
                "measurement_type" => $this->measurement_type,
                "images"           => ImageResource::collection($this->photos)
            ],
            "filters"          => FilterResource::collection($this->ad_filter_values),
            "is_active"        => $this->is_active,
            "is_deleted"       => $this->is_deleted,
            "is_archive"       => $this->is_archive,
            "cost"             => $this->cost
        ];

        if ($this->is_archive === true)
            $response["original_ad_id"] = $this->advertisement->id;

        return $response;
    }
}
