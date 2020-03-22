<?php

namespace App\Tests\Unit\ShoppingCart\Application\MessageHandler\Event;

use App\Shared\Domain\Event\UserCreatedEvent;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Application\MessageHandler\Event\CreateCartWhenUserCreatedEventHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateCartWhenUserCreatedEventHandlerTest extends TestCase
{
    public function testInvoke()
    {
        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $command = new UserCreatedEvent(new UserId());
        $handler = new CreateCartWhenUserCreatedEventHandler($entityManager);

        $handler($command);
    }
}