<?php

namespace App\ProductCatalog\Application\Http\Request;

class AddProductRequest
{
    /** @var string */
    private $name;

    /** @var string */
    private $price;

    public function __construct(string $name, string $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }
}