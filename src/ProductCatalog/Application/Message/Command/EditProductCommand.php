<?php

namespace App\ProductCatalog\Application\Message\Command;

use App\ProductCatalog\Domain\Model\Product;

class EditProductCommand
{
    /** @var Product */
    private $product;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $price;

    public function __construct(Product $product, string $name = null, string $price = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }
}