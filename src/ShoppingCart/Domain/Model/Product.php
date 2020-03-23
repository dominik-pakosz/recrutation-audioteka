<?php

namespace App\ShoppingCart\Domain\Model;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Money\Price;

class Product
{
    /** @var ProductId */
    private $id;

    /** @var string */
    private $name;

    /** @var Price */
    private $price;

    private function __construct(ProductId $id, string $name, Price $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public static function recreate(ProductId $id, string $name, Price $price)
    {
        return new self($id, $name, $price);
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): Price
    {
        return $this->price;
    }
}