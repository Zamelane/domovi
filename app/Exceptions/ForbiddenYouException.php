<?php

namespace App\Exceptions;

use Exception;

class ForbiddenYouException extends Exception
{
    public function __construct()
    {
        throw new ApiException(401, 'Forbidden you');
    }
}
