<?php

namespace App\User\Domain\Model;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identity\Email;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\User\Infrastructure\Repository\DoctrineUserRepository")
 */
class User implements UserInterface, AggregateRoot
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    private function __construct(UserId $id, Email $email, array $roles)
    {
        $this->id = $id->toString();
        $this->email = $email->getValue();
        $this->roles = $roles;
    }

    public static function create(UserId $id, Email $email, array $roles = [self::ROLE_USER])
    {
        return new self($id, $email, $roles);
    }

    public function id(): UserId
    {
        return new UserId($this->id);
    }

    public function email(): Email
    {
        return new Email($this->email);
    }

    public function addRole(string $role): void
    {
        $this->roles[] = $role;
    }

    public function getUsername(): string
    {
        return $this->email()->getValue();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
       return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        //do nothing
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        //do nothing
    }

    public function setEncodedPassword(string $encodedPassword): void
    {
        $this->password = $encodedPassword;
    }
}
