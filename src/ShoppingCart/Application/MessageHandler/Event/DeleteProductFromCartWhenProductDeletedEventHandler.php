<?php

namespace App\ShoppingCart\Application\MessageHandler\Event;

use App\Shared\Domain\Event\ProductDeletedEvent;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteProductFromCartWhenProductDeletedEventHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CartRepository */
    private $cartRepository;

    public function __construct(EntityManagerInterface $entityManager, CartRepository $cartRepository)
    {
        $this->entityManager = $entityManager;
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(ProductDeletedEvent $event): void
    {
        $cartItems = $this->cartRepository->findAllCartItemsWithProduct($event->getId());

        foreach ($cartItems as $cartItem) {
            $this->entityManager->remove($cartItem);
        }
    }
}