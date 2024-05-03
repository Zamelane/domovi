<?php

namespace App\Http\Resources\Days;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "day" => $this->code,
            "open_time" => $this->open_time,
            "close_time" => $this->close_time
        ];
    }
}
