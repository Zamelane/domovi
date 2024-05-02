<?php

namespace App\Http\Requests\Address;

use App\Http\Requests\ApiRequest;

class CityRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "city" => "required|string|min:1"
        ];
    }
}
