<?php

namespace App\ProductCatalog\Application\Message\Command;

use App\ProductCatalog\Domain\Model\Product;

class DeleteProductCommand
{
    /** @var Product */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}