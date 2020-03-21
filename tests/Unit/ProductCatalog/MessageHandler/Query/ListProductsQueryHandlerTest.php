<?php

namespace App\Tests\Unit\ProductCatalog\MessageHandler\Query;

use App\ProductCatalog\Application\Dto\Products as ProductsDto;
use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\ProductCatalog\Application\MessageHandler\Query\ListProductsQueryHandler;
use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListProductsQueryHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $products = [
            $product1 = Product::create(
                new ProductId(),
                'Product 1',
                new Price('999'),
                new UserId()
            ),
            $product2 = Product::create(
                new ProductId(),
                'Product 2',
                new Price('4999'),
                new UserId()
            ),
        ];
        /** @var MockObject|ProductRepository $productRepository */
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->expects(self::once())
            ->method('findAll')
            ->willReturn($products);

        $query = new ListProductsQuery();
        $handler = new ListProductsQueryHandler($productRepository);

        /** @var ProductsDto $productsDto */
        $productsDto = $handler($query);

        self::assertCount(2, $productsDto->getProducts());

        self::assertSame($product1->id()->toString(), $productsDto->getProducts()[0]->getId());
        self::assertSame($product1->name(), $productsDto->getProducts()[0]->getName());
        self::assertSame($product1->price()->getValue(), $productsDto->getProducts()[0]->getPrice());

        self::assertSame($product2->id()->toString(), $productsDto->getProducts()[1]->getId());
        self::assertSame($product2->name(), $productsDto->getProducts()[1]->getName());
        self::assertSame($product2->price()->getValue(), $productsDto->getProducts()[1]->getPrice());
    }
}