<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIException extends Exception
{
    private $errorCode;
    private $logId;
    private $additionalData;

    public function __construct(
        string $message = "",
        string $errorCode = "",
        int $statusCode = 403,
        array $additionalData = [],
        string $logId = ""
    ) {
        parent::__construct($message, $statusCode);
        $this->errorCode = $errorCode;
        $this->logId = $logId;
        $this->additionalData = $additionalData;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getLogId(): string
    {
        return $this->logId;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function report(APIException $e)
    {
        $logData = [
            'log_id' => $e->getLogId(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'status_code' => $e->getCode(),
            'error_code' =>  $e->getErrorCode(),
            'additional_data' => $e->getAdditionalData()
        ];

        Log::error("Handler handleAPIException, log_id:" . $e->getLogId(), $logData);
    }

    public function render(Request $request) : JsonResponse|bool
    {
        return response()->json([
            'code' =>  $this->getErrorCode(),
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
