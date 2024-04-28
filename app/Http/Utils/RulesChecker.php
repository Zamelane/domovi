<?php

namespace App\Http\Utils;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Validator;

class RulesChecker
{
    public static function check(array|null $rules)
    {
        if ($rules) {
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails())
                throw new ApiException(422, 'Request validation error', $validator->errors());
        }
    }
}
