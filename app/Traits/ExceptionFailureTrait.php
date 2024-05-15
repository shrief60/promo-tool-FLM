<?php

namespace App\Traits;

use Exception;
trait ExceptionFailureTrait
{
    private function handleFailure(string $errorCode, string $errorMessage, Exception $exception): array
    {
        return [
            'success' => false,
            'error_code' => $errorCode,
            'error_message' => $errorMessage,
            'additional_data' => [
                'exception_details' => [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine()
                ]
            ]
        ];
    }
}
