<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'review' => ReviewMinResource::make($this),
            'advertisement_id' => $this->advertisement_id
        ];
    }
}
