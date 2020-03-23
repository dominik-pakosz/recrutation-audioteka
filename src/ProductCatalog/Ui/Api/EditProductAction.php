<?php

namespace App\ProductCatalog\Ui\Api;

use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Application\Http\Request\EditProductRequest;
use App\ProductCatalog\Application\Http\Response\EditProductResponse;
use App\ProductCatalog\Application\Message\Command\EditProductCommand;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Ui\Api\AbstractAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class EditProductAction extends AbstractAction
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function __invoke(Product $product, Request $request)
    {
        /** @var EditProductRequest $editProductRequest */
        $editProductRequest = $this->getDeserializedData(EditProductRequest::class, $request);

        $command = new EditProductCommand(
            $product,
            $editProductRequest->getName(),
            $editProductRequest->getPrice()
        );

        return new EditProductResponse($this->command($command));
    }

    private function command(EditProductCommand $command): ProductDto
    {
        $envelope = $this->commandBus->dispatch($command);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var ProductDto $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}