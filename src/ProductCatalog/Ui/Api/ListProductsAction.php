<?php

namespace App\ProductCatalog\Ui\Api;

use App\ProductCatalog\Application\Http\Response\ListProductsResponse;
use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\Shared\Application\Dto\PaginatedCollection;
use App\Shared\Infrastructure\Service\Pagination\PaginationFactory;
use App\Shared\Ui\Api\AbstractAction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
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
    public function __invoke(Request $request)
    {
        $query = new ListProductsQuery($request->query->get(PaginationFactory::PAGE, PaginationFactory::DEFAULT_PAGE));

        return new ListProductsResponse($this->query($query));
    }

    public function query(ListProductsQuery $query): PaginatedCollection
    {
        $envelope = $this->queryBus->dispatch($query);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var PaginatedCollection $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}