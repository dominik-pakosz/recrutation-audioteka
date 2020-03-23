<?php

namespace App\ShoppingCart\Application\MessageHandler\Query;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use App\ShoppingCart\Application\Dto\Cart as CartDto;
use App\ShoppingCart\Application\Dto\Product as ProductDto;
use App\ShoppingCart\Application\Message\Query\GetCartQuery;
use App\ShoppingCart\Domain\Client\ProductCatalogClient;
use App\ShoppingCart\Domain\Model\Product;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetCartQueryHandler implements MessageHandlerInterface
{
    /** @var CartRepository */
    private $cartRepository;

    /** @var ProductCatalogClient */
    private $productCatalogClient;

    public function __construct(CartRepository $cartRepository, ProductCatalogClient $productCatalogClient)
    {
        $this->cartRepository = $cartRepository;
        $this->productCatalogClient = $productCatalogClient;
    }

    public function __invoke(GetCartQuery $query): CartDto
    {
        $cart = $this->cartRepository->findOneByUserId(new UserId($query->getUserId()));
        $products = $this->productCatalogClient->getProductsByProductIds($cart->getProductIds());

        $cartDto = new CartDto($this->sumProductPrices($products));

        foreach ($products as $product) {
            $cartDto->addProduct(
                new ProductDto(
                    $product->id()->toString(),
                    $product->name(),
                    $product->price()->getValue()
                )
            );
        }

        return $cartDto;
    }

    /** @var Product[] $products */
    private function sumProductPrices(array $products): string
    {
        $totalPrice = new Price('0');

        foreach ($products as $product) {
            $totalPrice = $totalPrice->add($product->price());
        }

        return $totalPrice->getValue();
    }
}