<?php

namespace App\User\Application\MessageHandler\Command;

use App\Shared\Domain\ValueObject\Identity\Email;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\User\Application\Dto\User as UserDto;
use App\User\Application\Message\Command\AddUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\Service\UserPasswordEncoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddUserCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserPasswordEncoder */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoder $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(AddUserCommand $command)
    {
        $user = User::create(
            new UserId(),
            new Email($command->getEmail())
        );

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $command->getPlainPassword());
        $user->setEncodedPassword($encodedPassword);

        $this->entityManager->persist($user);

        return new UserDto($user->id()->toString());
    }
}