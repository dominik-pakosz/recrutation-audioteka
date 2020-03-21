<?php

namespace App\ProductCatalog\Ui\Api;

use App\ProductCatalog\Application\Dto\Product;
use App\ProductCatalog\Application\Http\Request\AddProductRequest;
use App\ProductCatalog\Application\Http\Response\AddProductResponse;
use App\ProductCatalog\Application\Message\Command\AddProductCommand;
use App\Shared\Ui\Api\AbstractAction;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class AddProductAction extends AbstractAction
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
        /** @var AddProductRequest $addProductRequest */
        $addProductRequest = $this->getDeserializedData(AddProductRequest::class, $request);

        /** @var UserId $userId */
        $userId = $this->getUser()->id();

        $command = new AddProductCommand(
            $addProductRequest->getName(),
            $addProductRequest->getPrice(),
            $userId->toString()
        );

        return new AddProductResponse($this->command($command));
    }

    public function command(AddProductCommand $command): Product
    {
        $envelope = $this->commandBus->dispatch($command);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var Product $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}