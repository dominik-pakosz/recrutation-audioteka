<?php

namespace App\Shared\Application\Http\Response;

abstract class AbstractPaginatedCollectionResponse implements JsonResponse
{
    /** @var array */
    private $items;

    /** @var int */
    private $total;

    /** @var int */
    private $count;

    public function __construct(array $items, $totalItems)
    {
        $this->items = $items;
        $this->total = $totalItems;
        $this->count = count($items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}