<?php

namespace App\ShoppingCart\Application\MessageHandler\Event;

use App\Shared\Domain\Event\UserCreatedEvent;
use App\Shared\Domain\ValueObject\Identity\Uuid\CartId;
use App\ShoppingCart\Domain\Model\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCartWhenUserCreatedEventHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UserCreatedEvent $event): void
    {
        $cart = Cart::create(
            new CartId(),
            $event->getId()
        );

        $this->entityManager->persist($cart);
    }
}