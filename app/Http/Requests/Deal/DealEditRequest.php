<?php

namespace App\Http\Requests\Deal;

use App\Http\Requests\ApiRequest;

class DealEditRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'employee_id'       => 'integer|exists:users,id',
            'deal_status_id'    => 'integer|exists:deal_statuses,id',
            'percent'           => 'integer|min:0|max:99',
            'start_date'        => 'date|date_format:Y-m-d',
            'valid_until_date'  => 'date|date_format:Y-m-d',
            'address_id'        => 'integer|exists:addresses,id'
        ];
    }
}
