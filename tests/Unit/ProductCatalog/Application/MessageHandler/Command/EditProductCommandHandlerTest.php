<?php

namespace App\Tests\Unit\ProductCatalog\Application\MessageHandler\Command;

use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Application\Message\Command\EditProductCommand;
use App\ProductCatalog\Application\MessageHandler\Command\EditProductCommandHandler;
use App\ProductCatalog\Domain\Model\Product;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EditProductCommandHandlerTest extends TestCase
{
    /** @var Product */
    private $product;

    protected function setUp()
    {
        $this->product = Product::create(
            new ProductId(),
            'crazy name',
            new Price('5599'),
            new UserId()
        );
    }

    public function testInvokeWhenOnlyNameProvided()
    {


        $command = new EditProductCommand($this->product, 'new name');

        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $handler = new EditProductCommandHandler($entityManager);
        /** @var ProductDto $productDto */
        $productDto = $handler($command);

        self::assertSame($this->product->id()->toString(), $productDto->getId());
        self::assertSame('new name', $productDto->getName());
        self::assertSame($this->product->price()->getValue(), $productDto->getPrice());
    }

    public function testInvokeWhenOnlyPriceProvided()
    {
        $command = new EditProductCommand($this->product, null, '1045');

        /** @var MockObject|EntityManagerInterface $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())
            ->method('persist');

        $handler = new EditProductCommandHandler($entityManager);
        /** @var ProductDto $productDto */
        $productDto = $handler($command);

        self::assertSame($this->product->id()->toString(), $productDto->getId());
        self::assertSame($this->product->name(), $productDto->getName());
        self::assertSame('1045', $productDto->getPrice());
    }
}