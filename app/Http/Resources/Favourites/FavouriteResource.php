<?php

namespace App\Http\Resources\Favourites;

use App\Http\Resources\Advertisements\AdvertisementMinResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return AdvertisementMinResource::make($this->advertisement);
    }
}
