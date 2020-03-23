<?php

namespace App\ShoppingCart\Application\Http\Response;

use App\Shared\Application\Http\Response\JsonResponse;
use App\ShoppingCart\Application\Dto\Cart;
use App\ShoppingCart\Application\Dto\Product;
use Symfony\Component\HttpFoundation\Response;

class GetCartResponse implements JsonResponse
{
    /** @var Cart */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function responseCode(): int
    {
        return Response::HTTP_OK;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->cart->getProducts();
    }

    public function getTotalPrice(): string
    {
        return $this->cart->getTotalPrice();
    }
}