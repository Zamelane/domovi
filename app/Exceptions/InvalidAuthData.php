<?php

namespace App\Exceptions;

use Exception;

class InvalidAuthData extends Exception
{
    public function __construct()
    {
        throw new ApiException(401, 'Invalid auth data');
    }
}
