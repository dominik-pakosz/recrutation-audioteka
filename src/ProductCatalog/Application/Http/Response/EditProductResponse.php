<?php

namespace App\ProductCatalog\Application\Http\Response;

use App\ProductCatalog\Application\Dto\Product;
use App\Shared\Application\Http\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EditProductResponse implements JsonResponse
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

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getPrice(): string
    {
        return $this->product->getPrice();
    }
}