<?php

namespace App\Http\Requests\Advertisement;

use App\Http\Requests\ApiRequest;

class AdvertisementCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'street'                => 'required|min:3|max:255',
            'city'                  => 'required|string|min:3|max:35',
            'house'                 => 'required|integer|min:1',
            'advertisement_type_id' => 'required|exists:advertisement_types,id',
            'transaction_type'      => 'required|in:order,buy',
            'area'                  => 'required|integer',
            'measurement_type'      => 'required|in:ar,m2',
            'structure'             => 'integer',
            'building'              => 'integer',
            'apartament'            => 'integer',
            'description'           => 'string|min:10',
            'is_active'             => 'boolean',
            'cost'                  => 'required|decimal:0,2|min:0|max:99999999999999.99',
            'photos'                => 'array',
            'photos.*'              => 'file|max:2048|mimes:jpeg,jpg,png'
        ];
    }
}
