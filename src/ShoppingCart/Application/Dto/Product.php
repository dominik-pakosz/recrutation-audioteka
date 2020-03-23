<?php

namespace App\ShoppingCart\Application\Dto;

class Product
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $price;

    public function __construct(string $id, string $name, string $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
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