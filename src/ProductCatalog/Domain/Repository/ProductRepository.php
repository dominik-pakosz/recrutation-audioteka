<?php

namespace App\ProductCatalog\Domain\Repository;

use App\ProductCatalog\Domain\Model\Product;

interface ProductRepository
{
    /** @return Product[] */
    public function findAll(): array;
}