<?php

namespace App\ShoppingCart\Application\Dto;

class Cart
{
    /** @var string */
    private $totalPrice;

    /** @var Product[] */
    private $products = [];

    public function __construct(string $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /** @return Product[] */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }
}