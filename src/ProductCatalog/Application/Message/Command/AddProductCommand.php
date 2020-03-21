<?php

namespace App\ProductCatalog\Application\Message\Command;

class AddProductCommand
{
    /** @var string */
    private $name;

    /** @var string */
    private $price;

    /** @var string */
    private $createdBy;

    public function __construct(string $name, string $price, string $createdBy)
    {
        $this->name = $name;
        $this->price = $price;
        $this->createdBy = $createdBy;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
}