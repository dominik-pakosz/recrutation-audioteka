<?php

namespace App\Tests\Unit\ShoppingCart\Application\MessageHandler\Query;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use App\ShoppingCart\Application\Dto\Cart as CartDto;
use App\ShoppingCart\Application\Message\Query\GetCartQuery;
use App\ShoppingCart\Application\MessageHandler\Query\GetCartQueryHandler;
use App\ShoppingCart\Domain\Client\ProductCatalogClient;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Model\Product;
use App\ShoppingCart\Domain\Repository\CartRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCartQueryHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $cart = $this->createMock(Cart::class);
        $cart->expects(self::once())
            ->method('getProductIds')
            ->willReturn([
                $productId1 = new ProductId(),
                $productId2 = new ProductId()
            ]);

        /** @var MockObject|CartRepository $cartRepository */
        $cartRepository = $this->createMock(CartRepository::class);
        $cartRepository->expects(self::once())
            ->method('findOneByUserId')
            ->willReturn($cart);

        $product1 = Product::recreate(
            $productId1,
            'Extra product',
            new Price(1299)
        );

        $product2 = Product::recreate(
            $productId2,
            'Cool product',
            new Price(1945)
        );

        /** @var MockObject|ProductCatalogClient $productCatalogClient */
        $productCatalogClient = $this->createMock(ProductCatalogClient::class);
        $productCatalogClient->expects(self::once())
            ->method('getProductsByProductIds')
            ->willReturn([$product1, $product2]);

        $query = new GetCartQuery((new UserId())->toString());
        $handler = new GetCartQueryHandler($cartRepository, $productCatalogClient);

        /** @var CartDto $productsDto */
        $cartDto = $handler($query);

        self::assertCount(2, $cartDto->getProducts());
        self::assertSame('3244', $cartDto->getTotalPrice());

        self::assertSame($product1->id()->toString(), $cartDto->getProducts()[0]->getId());
        self::assertSame($product1->name(), $cartDto->getProducts()[0]->getName());
        self::assertSame($product1->price()->getValue(), $cartDto->getProducts()[0]->getPrice());

        self::assertSame($product2->id()->toString(), $cartDto->getProducts()[1]->getId());
        self::assertSame($product2->name(), $cartDto->getProducts()[1]->getName());
        self::assertSame($product2->price()->getValue(), $cartDto->getProducts()[1]->getPrice());
    }
}