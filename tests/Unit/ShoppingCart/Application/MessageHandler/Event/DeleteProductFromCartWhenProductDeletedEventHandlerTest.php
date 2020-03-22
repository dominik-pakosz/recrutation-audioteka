<?php

namespace App\Tests\Unit\ShoppingCart\Application\MessageHandler\Event;

use App\Shared\Domain\Event\ProductDeletedEvent;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\ShoppingCart\Application\MessageHandler\Event\DeleteProductFromCartWhenProductDeletedEventHandler;
use App\ShoppingCart\Domain\Model\CartItem;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteProductFromCartWhenProductDeletedEventHandlerTest extends TestCase
{
    public function testInvoke()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('remove');

        $cartItem = $this->createMock(CartItem::class);
        $cartRepository = $this->createMock(CartRepository::class);
        $cartRepository->expects(self::once())
            ->method('findAllCartItemsWithProduct')
            ->willReturn([$cartItem]);

        $command = new ProductDeletedEvent(new ProductId());
        $handler = new DeleteProductFromCartWhenProductDeletedEventHandler($entityManager, $cartRepository);

        $handler($command);
    }
}