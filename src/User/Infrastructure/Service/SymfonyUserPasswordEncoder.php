<?php

namespace App\User\Infrastructure\Service;

use App\User\Domain\Model\User;
use App\User\Domain\Service\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SymfonyUserPasswordEncoder implements UserPasswordEncoder
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encodePassword(User $user, string $plainPassword): string
    {
       return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }

}