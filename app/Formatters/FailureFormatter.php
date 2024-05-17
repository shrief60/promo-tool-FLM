<?php

namespace App\Formatters;

use Exception;

class FailureFormatter
{
    public function handle(string $errorCode, string $errorMessage, Exception $exception): array
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
