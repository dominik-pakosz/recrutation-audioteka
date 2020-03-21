<?php

namespace App\User\Domain\Repository;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\User\Domain\Model\User;

interface UserRepository
{
    public function findOneByEmail(string $email): ?User;

    public function findOneByUserId(UserId $userId): ?User;
}