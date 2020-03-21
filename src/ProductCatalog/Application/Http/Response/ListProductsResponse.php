<?php

namespace App\ProductCatalog\Application\Http\Response;

use App\ProductCatalog\Application\Dto\Product;
use App\ProductCatalog\Application\Dto\Products;
use App\Shared\Application\Http\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListProductsResponse implements JsonResponse
{
    /** @var integer */
    private $count;

    /** @var Product[] */
    private $products;

    /**
     * ListProductsResponse constructor.
     */
    public function __construct(Products $products)
    {
        $this->count = count($products->getProducts());
        $this->products = $products->getProducts();

    }

    public function responseCode(): int
    {
        return Response::HTTP_OK;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}