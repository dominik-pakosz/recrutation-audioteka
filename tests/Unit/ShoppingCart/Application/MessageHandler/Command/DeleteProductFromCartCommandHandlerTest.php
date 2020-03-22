<?php

namespace App\Tests\Unit\ShoppingCart\Application\MessageHandler\Command;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Application\Message\Command\DeleteProductFromCartCommand;
use App\ShoppingCart\Application\MessageHandler\Command\DeleteProductFromCartCommandHandler;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteProductFromCartCommandHandlerTest extends TestCase
{
    public function testInvoke()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $cart = $this->createMock(Cart::class);
        $cart->expects(self::once())
            ->method('deleteItem');

        /** @var MockObject|CartRepository $cartRepository */
        $cartRepository = $this->createMock(CartRepository::class);
        $cartRepository->expects(self::once())
            ->method('findOneByUserId')
            ->willReturn($cart);

        $command = new DeleteProductFromCartCommand(
            (new ProductId())->toString(),
            (new UserId())->toString()
        );
        $handler = new DeleteProductFromCartCommandHandler($entityManager, $cartRepository);

        $handler($command);
    }
}