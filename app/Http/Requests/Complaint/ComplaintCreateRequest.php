<?php

namespace App\Http\Requests\Complaint;

use App\Http\Requests\ApiRequest;

class ComplaintCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'advertisement_id' => 'required|integer|exists:advertisements,id',
            'description'      => 'required|string'
        ];
    }
}
