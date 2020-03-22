<?php

namespace App\ShoppingCart\Domain\Repository;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Domain\Exception\CartNotFoundException;
use App\ShoppingCart\Domain\Model\Cart;

interface CartRepository
{
    /** @throws CartNotFoundException */
    public function findOneByUserId(UserId $userId): ?Cart;
}