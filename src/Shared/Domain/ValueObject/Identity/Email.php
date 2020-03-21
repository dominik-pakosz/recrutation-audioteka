<?php

namespace App\Shared\Domain\ValueObject\Identity;

use App\Shared\Domain\Exception\CreateValueObjectException;
use App\Shared\Domain\ValueObject\BaseValueObject;

class Email extends BaseValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function guard(string $value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw CreateValueObjectException::guard(
                sprintf('Value %s is not valid email address', $value)
            );
        }
    }
}