<?php

namespace App\Http\Requests\Address;

use App\Http\Requests\ApiRequest;

class AddressRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "house"      => "required|integer|min:1",
            "structure"  => "integer|min:1",
            "building"   => "integer|min:1",
            "apartament" => "integer|min:1",
            "street"     => "required|string|min:3",
            "city"       => "required|string|min:3"
        ];
    }
}
