<?php

namespace App\ShoppingCart\Domain\Exception;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Domain\Model\Cart;

class CartMaxOccupancyException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function tooManyItems(UserId $userId)
    {
        return new self(
            sprintf(
                'Item can not be added. Maximum occupancy reached (%d), for User %s Cart',
                Cart::MAX_PRODUCTS,
                $userId->toString())
        );
    }
}