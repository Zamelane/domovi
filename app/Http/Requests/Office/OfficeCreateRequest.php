<?php

namespace App\Http\Requests\Office;

use App\Http\Requests\ApiRequest;

class OfficeCreateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'unique:offices,name',
            'work_days.*.code' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'work_days.*.open_time' => 'required|date_format:H:i',
            'work_days.*.close_time' => 'required|date_format:H:i|after:open_time',
            'is_active' => 'boolean',
            'address_id' => 'required|exists:addresses,id'
        ];
    }
}
