<?php

namespace App\Shared\Domain\Event;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;

class ProductDeletedEvent
{
    /** @var ProductId */
    private $id;

    public function __construct(ProductId $id)
    {
        $this->id = $id;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }
}