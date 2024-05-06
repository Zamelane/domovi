<?php

namespace App\Exceptions;

use Exception;

class YouBannedException extends Exception
{
    public function __construct()
    {
        throw new ApiException(401, 'You are banned');
    }
}
