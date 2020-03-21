<?php

namespace App\ProductCatalog\Application\MessageHandler\Command;

use App\ProductCatalog\Application\Message\Command\DeleteProductCommand;
use App\Shared\Domain\Event\ProductDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteProductCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var MessageBusInterface */
    private $eventBus;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $eventBus)
    {
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $this->entityManager->remove($command->getProduct());

        $this->eventBus->dispatch(new ProductDeletedEvent($command->getProduct()->id()));
    }
}
