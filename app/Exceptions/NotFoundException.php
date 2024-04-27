<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $name = "Data")
    {
        throw new ApiException(404, "$name not found");
    }
}
