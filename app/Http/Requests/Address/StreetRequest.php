<?php

namespace App\Http\Requests\Address;

use App\Http\Requests\ApiRequest;

class StreetRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "street" => "required|string|min:1",
            "city_id"=> "integer|min:1",
            "city"   => "string|min:1"
        ];
    }
}
