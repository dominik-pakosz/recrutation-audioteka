<?php

namespace App\ShoppingCart\Application\MessageHandler\Command;

use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Application\Exception\ProductAlreadyInCartException;
use App\ShoppingCart\Application\Message\Command\AddProductToCartCommand;
use App\ShoppingCart\Domain\Client\ProductCatalogClient;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCartCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var CartRepository */
    private $cartRepository;

    /** @var ProductCatalogClient */
    private $productCatalogClient;

    public function __construct(EntityManagerInterface $entityManager, CartRepository $cartRepository, ProductCatalogClient $productCatalogClient)
    {
        $this->entityManager = $entityManager;
        $this->cartRepository = $cartRepository;
        $this->productCatalogClient = $productCatalogClient;
    }

    /**
     * @throws ProductAlreadyInCartException
     */
    public function __invoke(AddProductToCartCommand $command): void
    {
        $cart = $this->cartRepository->findOneByUserId(new UserId($command->getUserId()));
        $product = $this->productCatalogClient->getProductByProductId(new ProductId($command->getProductId()));
        $this->checkIfProductIsNotInCart($cart, $product->id());
        $cart->addItem($product->id());

        $this->entityManager->persist($cart);
    }

    /**
     * @throws ProductAlreadyInCartException
     */
    private function checkIfProductIsNotInCart(Cart $cart, ProductId $productId): void
    {
        foreach ($cart->items() as $item) {
            if ($item->productId()->toString() === $productId->toString()) {
                throw ProductAlreadyInCartException::userCart($productId, $cart->owner());
            }
        }
    }
}