<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class SearchAdvertisementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'min_cost'              => 'decimal:0,2|min:0|max:99999999999999.99',
            'max_cost'              => 'decimal:0,2|min:0|max:99999999999999.99',
            'street'                => 'min:3|max:255',
            'city'                  => 'string|min:3|max:35',
            'advertisement_type_id' => 'exists:advertisement_types,id',
            'transaction_type'      => 'in:order,buy',
            'area'                  => 'integer',
            'count_rooms'           => 'integer|min:0|max:127',
            'filters'               => 'array|min:1'
        ];
    }
}
