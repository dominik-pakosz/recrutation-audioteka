<?php

namespace App\Shared\Domain\ValueObject\Identity\Uuid;

interface UuidInterface
{
    public function toString(): string;

    public function equals(UuidInterface $uuid): bool;
}