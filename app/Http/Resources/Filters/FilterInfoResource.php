<?php

namespace App\Http\Resources\Filters;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $returned =  [
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type
        ];

        if ($this->type === 'select')
            $returned['values'] = FilterValuesResource::collection($this->filter_values);

        return $returned;
    }
}
