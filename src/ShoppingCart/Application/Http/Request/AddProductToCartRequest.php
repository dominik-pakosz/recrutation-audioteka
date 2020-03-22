<?php

namespace App\ShoppingCart\Application\Http\Request;

class AddProductToCartRequest
{
    /** @var string */
    private $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
}