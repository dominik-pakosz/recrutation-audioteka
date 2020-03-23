<?php

namespace App\ProductCatalog\Domain\Model;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\ProductCatalog\Infrastructure\Repository\DoctrineProductRepository")
 */
class Product implements AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Using string to avoid problems with int
     * @ORM\Column(type="string")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $createdBy;

    private function __construct(ProductId $id, string $name, Price $price, UserId $createdBy)
    {
        $this->id = $id->toString();
        $this->name = $name;
        $this->price = $price->getValue();
        $this->createdBy = $createdBy->toString();
    }

    public static function create(ProductId $id, string $name, Price $price, UserId $createdBy)
    {
        return new self($id, $name, $price, $createdBy);
    }

    public function id(): ProductId
    {
        return new ProductId($this->id);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): Price
    {
        return new Price($this->price);
    }

    public function createdBy(): UserId
    {
        return new UserId($this->createdBy);
    }

    public function canDelete(UserId $userId): bool
    {
        return $this->createdBy()->toString() === $userId->toString();
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function changePrice(Price $price): void
    {
        $this->price = $price->getValue();
    }
}