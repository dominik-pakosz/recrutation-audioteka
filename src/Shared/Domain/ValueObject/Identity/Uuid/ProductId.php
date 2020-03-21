<?php

namespace App\Shared\Domain\ValueObject\Identity\Uuid;

class ProductId extends BaseUuid
{
    public function __construct(string $uuid = null)
    {
        parent::__construct($uuid);
    }
}