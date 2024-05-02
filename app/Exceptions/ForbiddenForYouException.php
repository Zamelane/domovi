<?php

namespace App\Exceptions;

use Exception;

class ForbiddenForYouException extends Exception
{
    public function __construct($message = 'Forbidden for you')
    {
        throw new ApiException(401, $message);
    }
}
