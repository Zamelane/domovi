<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementEditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'street'                => 'min:3|max:255',
            'city'                  => 'string|min:3|max:35',
            'house'                 => 'integer|min:1',
            'advertisement_type_id' => 'exists:advertisement_types,id',
            'transaction_type'      => 'in:order,buy',
            'area'                  => 'integer',
            'measurement_type'      => 'in:ar,m2',
            'structure'             => 'integer',
            'building'              => 'integer',
            'apartament'            => 'integer',
            'is_active'             => 'boolean',
            'is_moderated'          => 'boolean',
            'cost'                  => 'decimal:0,2|min:0|max:99999999999999.99',
            'photos'                => 'array',
            'photos.*'              => 'file|max:2048|mimes:jpeg,jpg,png',
            'photosToDelete'        => 'array',
            'photosToDelete.*'      => 'exists:photos,name',
        ];
    }
}
