<?php

namespace App\ProductCatalog\Domain\Repository;

use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;

interface ProductRepository
{
    /** @return Product[] */
    public function findAll(): array;

    public function findOneById(ProductId $id): ?Product;

    /**
     * @param ProductId[] $productIds
     * @return Product[]
     */
    public function findAllByIds(array $productIds): array;
}