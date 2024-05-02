<?php

namespace App\Http\Requests\Deal;

use App\Http\Requests\ApiRequest;

class DealCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'advertisement_id' => 'required|integer|exists:advertisements,id',
            'address_id'       => 'required|integer|exists:addresses,id'
        ];
    }
}
