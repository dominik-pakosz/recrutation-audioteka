<?php

namespace App\ProductCatalog\Application\Http\Response;

use App\ProductCatalog\Application\Dto\Product;
use App\Shared\Application\Http\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddProductResponse implements JsonResponse
{
    /** @var Product */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function responseCode(): int
    {
        return Response::HTTP_CREATED;
    }

    public function getId(): string
    {
        return $this->product->getId();
    }
}