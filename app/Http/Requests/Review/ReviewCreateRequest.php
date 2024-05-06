<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\ApiRequest;

class ReviewCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'advertisement_id' => 'required|integer|exists:advertisements,id',
            'stars'            => 'required|integer|min:1|max:5',
            'description'      => 'required|string'
        ];
    }
}
