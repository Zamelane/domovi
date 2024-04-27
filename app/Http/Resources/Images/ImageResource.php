<?php

namespace App\Http\Resources\Images;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return $this->name;
    }
}
