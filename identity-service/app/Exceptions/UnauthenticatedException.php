<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthenticatedException extends HttpException
{
    public function __construct(string $message = 'Unauthenticated', ?\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(401, $message, $previous, $headers, $code);
    }
}
