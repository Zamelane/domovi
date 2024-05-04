<?php

namespace App\Http\Requests\Office;

use App\Http\Requests\ApiRequest;

class OfficeEditRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'unique:offices,name,'.$this->id,
            'work_days.*.code' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'work_days.*.open_time' => 'date_format:H:i',
            'work_days.*.close_time' => 'date_format:H:i|after:open_time',
            'is_active' => 'boolean',
            'address_id' => 'exists:addresses,id'
        ];
    }
}
