<?php

namespace App\Tests\Unit\ProductCatalog\MessageHandler\Command;

use App\ProductCatalog\Application\Dto\Product;
use App\ProductCatalog\Application\Message\Command\AddProductCommand;
use App\ProductCatalog\Application\MessageHandler\Command\AddProductCommandHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AddProductCommandHandlerTest extends TestCase
{
    public function testInvoke()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $command = new AddProductCommand(
            'Best product ever',
            '5099',
            Uuid::uuid4()->toString()
        );

        $handler = new AddProductCommandHandler($entityManager);

        /** @var Product $productDto */
        $productDto = $handler($command);

        self::assertTrue(Uuid::isValid($productDto->getId()));
        self::assertSame($command->getName(), $productDto->getName());
        self::assertSame($command->getPrice(), $productDto->getPrice());
    }
}