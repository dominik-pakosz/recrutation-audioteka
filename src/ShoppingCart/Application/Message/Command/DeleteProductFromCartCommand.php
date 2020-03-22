<?php

namespace App\ShoppingCart\Application\Message\Command;

class DeleteProductFromCartCommand
{
    /** @var string */
    private $productId;

    /** @var string */
    private $userId;

    public function __construct(string $productId, string $userId)
    {
        $this->productId = $productId;
        $this->userId = $userId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}