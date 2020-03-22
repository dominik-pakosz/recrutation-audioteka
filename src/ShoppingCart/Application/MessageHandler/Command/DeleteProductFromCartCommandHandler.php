<?php

namespace App\ShoppingCart\Application\MessageHandler\Command;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Application\Message\Command\DeleteProductFromCartCommand;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteProductFromCartCommandHandler implements MessageHandlerInterface
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

    public function __invoke(DeleteProductFromCartCommand $command): void
    {
        $cart = $this->cartRepository->findOneByUserId(new UserId($command->getUserId()));
        $cart->deleteItem(new ProductId($command->getProductId()));

        $this->entityManager->persist($cart);
    }
}