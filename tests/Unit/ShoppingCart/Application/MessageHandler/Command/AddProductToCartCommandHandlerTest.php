<?php

namespace App\Tests\Unit\ShoppingCart\Application\MessageHandler\Command;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Application\Exception\ProductAlreadyInCartException;
use App\ShoppingCart\Application\Message\Command\AddProductToCartCommand;
use App\ShoppingCart\Application\MessageHandler\Command\AddProductToCartCommandHandler;
use App\ShoppingCart\Domain\Client\ProductCatalogClient;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Model\CartItem;
use App\ShoppingCart\Domain\Model\Product;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AddProductToCartCommandHandlerTest extends TestCase
{
    public function testInvoke()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $cart = $this->createMock(Cart::class);
        $cart->expects(self::once())
            ->method('addItem');
        $cart->expects(self::once())
            ->method('items')
            ->willReturn([]);

        /** @var MockObject|CartRepository $cartRepository */
        $cartRepository = $this->createMock(CartRepository::class);
        $cartRepository->expects(self::once())
            ->method('findOneByUserId')
            ->willReturn($cart);

        $product = $this->createMock(Product::class);
        $product->expects(self::exactly(2))
            ->method('id')
            ->willReturn(new ProductId());

        /** @var MockObject|ProductCatalogClient $productCatalogClient */
        $productCatalogClient = $this->createMock(ProductCatalogClient::class);
        $productCatalogClient->expects(self::once())
            ->method('getProductByProductId')
            ->willReturn($product);

        $command = new AddProductToCartCommand(
            (new ProductId())->toString(),
            (new UserId())->toString()
        );
        $handler = new AddProductToCartCommandHandler($entityManager, $cartRepository, $productCatalogClient);

        $handler($command);
    }

    public function testInvokeWhenProductAlreadyInCart()
    {
        $productId = new ProductId();
        $userId = new UserId();
        $this->expectException(ProductAlreadyInCartException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Product %s is already in Cart which belong to User %s',
                $productId->toString(),
                $userId->toString()
            )
        );

        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $cartItem = $this->createMock(CartItem::class);
        $cartItem->expects(self::once())
            ->method('productId')
            ->willReturn($productId);
        $cart = $this->createMock(Cart::class);
        $cart->expects(self::once())
            ->method('items')
            ->willReturn([$cartItem]);
        $cart->expects(self::once())
            ->method('owner')
            ->willReturn($userId);

        /** @var MockObject|CartRepository $cartRepository */
        $cartRepository = $this->createMock(CartRepository::class);
        $cartRepository->expects(self::once())
            ->method('findOneByUserId')
            ->willReturn($cart);

        $product = $this->createMock(Product::class);
        $product->expects(self::once())
            ->method('id')
            ->willReturn($productId);

        /** @var MockObject|ProductCatalogClient $productCatalogClient */
        $productCatalogClient = $this->createMock(ProductCatalogClient::class);
        $productCatalogClient->expects(self::once())
            ->method('getProductByProductId')
            ->willReturn($product);

        $command = new AddProductToCartCommand(
            $productId->toString(),
            $userId->toString()
        );
        $handler = new AddProductToCartCommandHandler($entityManager, $cartRepository, $productCatalogClient);

        $handler($command);
    }
}