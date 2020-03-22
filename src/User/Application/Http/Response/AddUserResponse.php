<?php

namespace App\User\Application\Http\Response;

use App\Shared\Application\Http\Response\JsonResponse;
use App\User\Application\Dto\User;
use Symfony\Component\HttpFoundation\Response;

class AddUserResponse implements JsonResponse
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function responseCode(): int
    {
        return Response::HTTP_CREATED;
    }

    public function getId(): string
    {
        return $this->user->getId();
    }
}