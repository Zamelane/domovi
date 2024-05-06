<?php

namespace App\Http\Requests\Filter;

use App\Http\Requests\ApiRequest;

class FilterGetRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'code' => 'string|exists:filters,code',
            'advertisement_type' => 'string|exists:advertisement_types,name'
        ];
    }
}
