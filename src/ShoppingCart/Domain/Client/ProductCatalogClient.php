<?php

namespace App\ShoppingCart\Domain\Client;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\ShoppingCart\Domain\Model\Product;

interface ProductCatalogClient
{
    public function getProductByProductId(ProductId $productId): Product;

    /**
     * @param ProductId[] $productIds
     * @return Product[]
     */
    public function getProductsByProductIds(array $productIds): array;
}