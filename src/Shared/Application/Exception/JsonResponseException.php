<?php

namespace App\Shared\Application\Exception;

use App\Shared\Application\Http\Response\JsonResponse;

class JsonResponseException extends \Exception
{
    private const INTERFACE_NOT_IMPLEMENTED = 'Interface %s is not implemented in class %s';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function interfaceNotImplemented(string $class): self
    {
        return new self(
            sprintf(self::INTERFACE_NOT_IMPLEMENTED, JsonResponse::class, $class)
        );
    }
}