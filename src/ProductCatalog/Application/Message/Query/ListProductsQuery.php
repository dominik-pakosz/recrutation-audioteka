<?php

namespace App\ProductCatalog\Application\Message\Query;

class ListProductsQuery
{
    /** @var int */
    private $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}