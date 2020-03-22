<?php

namespace App\Tests\Unit\User\MessageHandler\Command;

use App\User\Application\Dto\User;
use App\User\Application\Message\Command\AddUserCommand;
use App\User\Application\MessageHandler\Command\AddUserCommandHandler;
use App\User\Domain\Service\UserPasswordEncoder;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class AddUserCommandHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $command = new AddUserCommand(
            'example@gmail.com',
            'plainPassword'
        );

        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        /** @var MockObject|MessageBusInterface $eventBus */
        $eventBus = $this->createMock(MessageBusInterface::class);
        $eventBus->expects(self::once())
            ->method('dispatch')
            ->willReturn(new Envelope($command));;

        /** @var MockObject|UserPasswordEncoder $userPasswordEncoder */
        $userPasswordEncoder = $this->createMock(UserPasswordEncoder::class);
        $userPasswordEncoder->expects(self::once())
            ->method('encodePassword')
            ->willReturn('encodedPassword');

        $handler = new AddUserCommandHandler($entityManager, $userPasswordEncoder, $eventBus);

        /** @var User $userDto */
        $userDto = $handler($command);

        self::assertTrue(Uuid::isValid($userDto->getId()));
    }
}