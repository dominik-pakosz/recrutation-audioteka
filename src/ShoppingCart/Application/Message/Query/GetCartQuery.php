<?php

namespace App\ShoppingCart\Application\Message\Query;

class GetCartQuery
{
    /** @var string */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}