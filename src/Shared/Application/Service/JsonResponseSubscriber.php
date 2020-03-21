<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Shared\Application\Exception\JsonResponseException;
use App\Shared\Application\Http\Response\JsonResponse as AppJsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponseSubscriber implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['createJsonResponse'],
            ],
        ];
    }

    public function createJsonResponse(ViewEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        /** @var AppJsonResponse $controllerResult */
        $controllerResult = $event->getControllerResult();

        if (!$controllerResult instanceof AppJsonResponse) {
            throw JsonResponseException::interfaceNotImplemented(get_class($controllerResult));
        }

        $response = JsonResponse::fromJsonString(
            $this
                ->serializer
                ->serialize(
                    $controllerResult,
                    'json'
                ),
            $controllerResult->responseCode()
        );

        $event->setResponse($response);
    }
}
