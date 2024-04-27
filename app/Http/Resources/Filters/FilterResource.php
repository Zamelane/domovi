<?php

namespace App\Http\Resources\Filters;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->filter->name,
            "code" => $this->filter->code,
            "value" => $this->value,
        ];
    }
}
