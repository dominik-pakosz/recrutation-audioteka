<?php

namespace App\Shared\Domain\Exception;

class CreateValueObjectException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function guard(string $message): self
    {
        return new self($message);
    }
}