<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\ApiRequest;

class ReviewEditRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'stars'            => 'required|integer|min:1|max:5',
            'description'      => 'required|string'
        ];
    }
}
