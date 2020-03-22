<?php

namespace App\User\Application\MessageHandler\Command;

use App\Shared\Domain\Event\UserCreatedEvent;
use App\Shared\Domain\ValueObject\Identity\Email;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\User\Application\Dto\User as UserDto;
use App\User\Application\Message\Command\AddUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\Service\UserPasswordEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddUserCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserPasswordEncoder */
    private $passwordEncoder;

    /** @var MessageBusInterface */
    private $eventBus;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoder $passwordEncoder, MessageBusInterface $eventBus)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->eventBus = $eventBus;
    }

    public function __invoke(AddUserCommand $command): UserDto
    {
        $userId = new UserId();
        $user = User::create(
            $userId,
            new Email($command->getEmail())
        );

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $command->getPlainPassword());
        $user->setEncodedPassword($encodedPassword);

        $this->entityManager->persist($user);

        $this->eventBus->dispatch(new UserCreatedEvent($userId));

        return new UserDto($user->id()->toString());
    }
}