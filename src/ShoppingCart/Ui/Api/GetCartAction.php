<?php

namespace App\ShoppingCart\Ui\Api;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Ui\Api\AbstractAction;
use App\ShoppingCart\Application\Dto\Cart;
use App\ShoppingCart\Application\Http\Response\GetCartResponse;
use App\ShoppingCart\Application\Message\Query\GetCartQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetCartAction extends AbstractAction
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
        /** @var UserId $userId */
        $userId = $this->getUser()->id();
        $query = new GetCartQuery($userId->toString());

        return new GetCartResponse($this->query($query));
    }

    private function query(GetCartQuery $query): Cart
    {
        $envelope = $this->queryBus->dispatch($query);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var Cart $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}