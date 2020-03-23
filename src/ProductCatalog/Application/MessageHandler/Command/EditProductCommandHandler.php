<?php

namespace App\ProductCatalog\Application\MessageHandler\Command;

use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Application\Message\Command\EditProductCommand;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Domain\ValueObject\Money\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EditProductCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(EditProductCommand $command): ProductDto
    {
        $product = $command->getProduct();
        $this->editProductName($product, $command->getName());
        $this->editProductPrice($product, $command->getPrice());

        $this->entityManager->persist($product);

        return new ProductDto(
            $product->id()->toString(),
            $product->name(),
            $product->price()->getValue()
        );
    }

    private function editProductName(Product $product, string $newName = null): void
    {
        if ($newName) {
            $product->changeName($newName);
        }
    }

    private function editProductPrice(Product $product, string $newPrice = null): void
    {
        if ($newPrice) {
            $product->changePrice(new Price($newPrice));
        }
    }
}
