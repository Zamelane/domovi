<?php

namespace App\Http\Resources\Filters;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterValuesResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return $this->value;
    }
}
