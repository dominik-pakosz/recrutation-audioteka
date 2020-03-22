<?php

namespace App\ShoppingCart\Domain\Exception;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;

class ProductNotFoundException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function byProductId(ProductId $productId)
    {
        return new self(
            sprintf('Product with id %s not found', $productId->toString())
        );
    }
}