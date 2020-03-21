<?php

namespace App\ProductCatalog\Application\Http\Response;

use App\Shared\Application\Dto\PaginatedCollection;
use App\Shared\Application\Http\Response\AbstractPaginatedCollectionResponse;
use Symfony\Component\HttpFoundation\Response;

class ListProductsResponse extends AbstractPaginatedCollectionResponse
{
    public function __construct(PaginatedCollection $productsCollection)
    {
        parent::__construct($productsCollection->getItems(), $productsCollection->getTotal());

    }

    public function responseCode(): int
    {
        return Response::HTTP_OK;
    }
}