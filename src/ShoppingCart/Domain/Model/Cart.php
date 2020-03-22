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
     *   cascade={"persist"},
     *   orphanRemoval=true
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

    public function deleteItem(ProductId $productId): void
    {
        foreach ($this->items as $item) {
            if ($item->productId()->toString() === $productId->toString()) {
                $this->items->removeElement($item);
            }
        }
    }

    /** @return CartItem[] */
    public function items(): array
    {
        return $this->items->toArray();
    }

    public function owner(): UserId
    {
        return new UserId($this->userId);
    }
}