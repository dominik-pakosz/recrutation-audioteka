<?php

namespace App\Shared\Application\Dto;

class PaginatedCollection
{
    /** @var array */
    private $items;

    /** @var int */
    private $total;

    public function __construct(array $items, $totalItems)
    {
        $this->items = $items;
        $this->total = $totalItems;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}