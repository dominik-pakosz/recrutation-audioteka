<?php

namespace App\Shared\Domain\ValueObject\Money;

use App\Shared\Domain\Exception\CreateValueObjectException;
use App\Shared\Domain\ValueObject\BaseValueObject;
use Money\Money;

class Price extends BaseValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function guard(string $value): void
    {
        try {
            Money::PLN($value);
        } catch (\InvalidArgumentException $exception) {
            throw CreateValueObjectException::guard(
                sprintf('Value %s is not valid price. Price should be provided as pennies.', $value)
            );
        }
    }
}