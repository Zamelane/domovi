<?php

namespace App\Http\Requests\Statistics;

use App\Http\Requests\ApiRequest;

class IncomeStatisicsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "start_date" => "date_format:Y-m-d",
            "end_date"   => "date_format:Y-m-d|after:start_date"
        ];
    }
}
