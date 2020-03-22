<?php

namespace App\ShoppingCart\Ui\Api;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Ui\Api\AbstractAction;
use App\ShoppingCart\Application\Http\Request\AddProductToCartRequest;
use App\ShoppingCart\Application\Message\Command\AddProductToCartCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class AddProductToCartAction extends AbstractAction
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
    public function __invoke(Request $request)
    {
        /** @var AddProductToCartRequest $addProductToCartRequest */
        $addProductToCartRequest = $this->getDeserializedData(AddProductToCartRequest::class, $request);

        /** @var UserId $userId */
        $userId = $this->getUser()->id();

        $command = new AddProductToCartCommand(
            $addProductToCartRequest->getProductId(),
            $userId->toString()
        );

        $this->commandBus->dispatch($command);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}