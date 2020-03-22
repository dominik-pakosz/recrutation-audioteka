<?php

namespace App\ShoppingCart\Domain\Model;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity()
 */
class CartItem
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $productId;

    /**
     * @ORM\ManyToOne(targetEntity="App\ShoppingCart\Domain\Model\Cart", inversedBy="items")
     * @JoinColumn(name="cart_id", referencedColumnName="id", nullable=false)
     */
    private $cart;

    private function __construct(ProductId $productId, Cart $cart)
    {
        $this->productId = $productId->toString();
        $this->cart = $cart;
    }

    public static function create(ProductId $productId, Cart $cart)
    {
        return new self($productId, $cart);
    }

    public function productId(): ProductId
    {
        return new ProductId($this->productId);
    }
}