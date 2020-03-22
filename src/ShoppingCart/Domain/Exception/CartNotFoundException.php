<?php

namespace App\ShoppingCart\Domain\Exception;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;

class CartNotFoundException extends \DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function forUserId(UserId $userId)
    {
        return new self(
            sprintf('Cart not found for user %s', $userId->toString())
        );
    }
}