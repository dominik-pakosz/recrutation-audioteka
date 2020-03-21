<?php

namespace App\ProductCatalog\Ui\Api;

use App\ProductCatalog\Application\Dto\Products;
use App\ProductCatalog\Application\Http\Response\ListProductsResponse;
use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\Shared\Ui\Api\AbstractAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class ListProductsAction extends AbstractAction
{
    /** @var MessageBusInterface */
    private $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function __invoke()
    {
        $query = new ListProductsQuery();

        return new ListProductsResponse($this->query($query));
    }

    public function query(ListProductsQuery $query): Products
    {
        $envelope = $this->queryBus->dispatch($query);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var Products $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}