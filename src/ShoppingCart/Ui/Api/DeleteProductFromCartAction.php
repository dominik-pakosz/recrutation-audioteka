<?php

namespace App\ShoppingCart\Ui\Api;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Ui\Api\AbstractAction;
use App\ShoppingCart\Application\Message\Command\DeleteProductFromCartCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteProductFromCartAction extends AbstractAction
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function __invoke(string $productId)
    {
        /** @var UserId $userId */
        $userId = $this->getUser()->id();

        $command = new DeleteProductFromCartCommand(
            $productId,
            $userId->toString()
        );

        $this->commandBus->dispatch($command);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}