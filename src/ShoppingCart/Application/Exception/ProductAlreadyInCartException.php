<?php

namespace App\ShoppingCart\Application\Exception;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;

class ProductAlreadyInCartException extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function userCart(ProductId $productId, UserId $userId)
    {
        return new self(
            sprintf(
                'Product %s is already in Cart which belong to User %s',
                $productId->toString(),
                $userId->toString()
            )
        );
    }
}