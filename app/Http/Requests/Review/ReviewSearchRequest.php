<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\ApiRequest;

class ReviewSearchRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,id',
            'is_moderated' => 'boolean'
        ];
    }
}
