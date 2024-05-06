<?php

namespace App\Http\Resources\Complaint;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => UserResource::make($this->user),
            'description' => $this->description,
            'advertisement_id' => $this->advertisement_id,
            'is_review' => $this->is_review
        ];
    }
}
