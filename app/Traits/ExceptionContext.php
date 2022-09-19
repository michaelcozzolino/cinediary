<?php

declare(strict_types=1);

namespace App\Traits;

use Exception;

class ExceptionContext
{
    /**
     * Get the formatted context for exceptions.
     *
     * @param  Exception  $exception
     *
     * @return array
     */
    public static function getContext(Exception $exception): array
    {
        return [
            'exception_code' => $exception->getCode(),
            'exception_message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'trace' => $exception->getTrace(),
        ];
    }
}
