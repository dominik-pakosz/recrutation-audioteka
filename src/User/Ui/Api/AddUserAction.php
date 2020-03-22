<?php

namespace App\User\Ui\Api;

use App\Shared\Ui\Api\AbstractAction;
use App\User\Application\Dto\User;
use App\User\Application\Http\Request\AddUserRequest;
use App\User\Application\Http\Response\AddUserResponse;
use App\User\Application\Message\Command\AddUserCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class AddUserAction extends AbstractAction
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
    public function __invoke(Request $request)
    {
        /** @var AddUserRequest $addUserRequest */
        $addUserRequest = $this->getDeserializedData(AddUserRequest::class, $request);

        $command = new AddUserCommand(
            $addUserRequest->getEmail(),
            $addUserRequest->getPlainPassword()
        );

        return new AddUserResponse($this->command($command));
    }

    public function command(AddUserCommand $command): User
    {
        $envelope = $this->commandBus->dispatch($command);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);
        /** @var User $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}