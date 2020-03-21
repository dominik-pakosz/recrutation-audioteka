<?php

namespace App\ProductCatalog\Application\Dto;

class Products
{
    /** @var Product[] */
    private $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    /** @return Product[] */
    public function getProducts(): array
    {
        return $this->products;
    }
}