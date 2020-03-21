<?php

namespace App\ProductCatalog\Application\MessageHandler\Command;

use App\ProductCatalog\Application\Message\Command\AddProductCommand;
use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductCommandHandler implements MessageHandlerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(AddProductCommand $command): ProductDto
    {
        $product = Product::create(
            new ProductId(),
            $command->getName(),
            new Price($command->getPrice()),
            new UserId($command->getCreatedBy())
        );

        $this->entityManager->persist($product);

        return new ProductDto(
            $product->id()->toString(),
            $product->name(),
            $product->price()->getValue()
        );
    }
}
