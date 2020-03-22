<?php

namespace App\ShoppingCart\Domain\Model;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\Identity\Uuid\CartId;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\ShoppingCart\Infrastructure\Repository\DoctrineCartRepository")
 */
class Cart implements AggregateRoot
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
    private $userId;

    /**
     * @var Collection|CartItem[]
     *
     * @ORM\OneToMany(
     *   targetEntity="App\ShoppingCart\Domain\Model\CartItem",
     *   mappedBy="cart",
     *   cascade={"PERSIST"}
     * )
     */
    private $items;

    private function __construct(CartId $id, UserId $userId)
    {
        $this->id = $id->toString();
        $this->userId = $userId->toString();
        $this->items = new ArrayCollection();
    }

    public static function create(CartId $id, UserId $userId): self
    {
        return new self($id, $userId);
    }

    public function addItem(ProductId $productId): void
    {
        $this->items->add(
            CartItem::create($productId, $this)
        );
    }

    /** @return CartItem[] */
    public function items(): array
    {
        return $this->items->toArray();
    }
}