<?php

namespace App\Shared\Domain\ValueObject;

abstract class BaseValueObject implements ValueObject
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    abstract public function guard(string $value): void;

    public function getValue(): string
    {
        return $this->value;
    }
}