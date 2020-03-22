<?php

namespace App\ShoppingCart\Domain\Repository;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Domain\Exception\CartNotFoundException;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Model\CartItem;

interface CartRepository
{
    /** @throws CartNotFoundException */
    public function findOneByUserId(UserId $userId): ?Cart;

    /** @return CartItem[] */
    public function findAllCartItemsWithProduct(ProductId $productId): array;
}