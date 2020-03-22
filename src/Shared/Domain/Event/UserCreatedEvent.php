<?php

namespace App\Shared\Domain\Event;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;

class UserCreatedEvent
{
    /** @var UserId */
    private $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}