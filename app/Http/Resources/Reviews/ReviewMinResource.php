<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewMinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => UserResource::make($this->user),
            'stars' => $this->stars,
            'description' => $this->description,
            'create_datetime' => $this->create_datetime,
            'update_datetime' => $this->update_datetime,
            'is_services' => $this->is_services,
            'is_moderation' => $this->is_moderation
        ];
    }
}
