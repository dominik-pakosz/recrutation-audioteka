<?php

namespace App\Tests\Unit\ProductCatalog\Application\MessageHandler\Command;

use App\ProductCatalog\Application\Message\Command\DeleteProductCommand;
use App\ProductCatalog\Application\MessageHandler\Command\DeleteProductCommandHandler;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteProductCommandHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $product = Product::create(
            new ProductId(),
            'crazy name',
            new Price('5599'),
            new UserId()
        );

        $command = new DeleteProductCommand($product);

        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('remove');
        /** @var MockObject|MessageBusInterface $eventBus */
        $eventBus = $this->createMock(MessageBusInterface::class);
        $eventBus->expects(self::once())
            ->method('dispatch')
            ->willReturn(new Envelope($command));;

        $handler = new DeleteProductCommandHandler($entityManager, $eventBus);
        $handler($command);
    }
}