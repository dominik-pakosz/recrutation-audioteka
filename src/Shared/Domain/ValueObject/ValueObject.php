<?php

namespace App\Shared\Domain\ValueObject;

interface ValueObject
{
    public function guard(string $value): void;

    public function getValue(): string;
}