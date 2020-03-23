<?php

namespace App\ProductCatalog\Application\Http\Request;

class EditProductRequest
{
    /** @var string|null */
    private $name;

    /** @var string|null */
    private $price;

    public function __construct(string $name = null, string $price = null)
    {
        $this->name = $name;
        $this->price = $price;
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