<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\ApiRequest;

class ReviewSetModeratedStatusRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'is_moderation' => 'required|boolean'
        ];
    }
}
