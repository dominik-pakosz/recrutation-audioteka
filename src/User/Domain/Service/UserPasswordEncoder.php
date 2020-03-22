<?php

namespace App\User\Domain\Service;

use App\User\Domain\Model\User;

interface UserPasswordEncoder
{
    public function encodePassword(User $user, string $plainPassword): string;
}