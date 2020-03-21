<?php

namespace App\ProductCatalog\Ui\Api;

use App\ProductCatalog\Application\Message\Command\DeleteProductCommand;
use App\ProductCatalog\Application\Voter\ProductVoter;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Ui\Api\AbstractAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteProductAction extends AbstractAction
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
    public function __invoke(Product $product)
    {
        $this->denyAccessUnlessGranted(ProductVoter::DELETE, $product);

        $command = new DeleteProductCommand($product);

        $this->commandBus->dispatch($command);

        return new Response(null, 204);
    }
}