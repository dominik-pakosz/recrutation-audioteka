<?php

namespace App\Tests\Unit\ProductCatalog\Application\MessageHandler\Query;

use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\ProductCatalog\Application\MessageHandler\Query\ListProductsQueryHandler;
use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\ProductCatalog\Infrastructure\Repository\DoctrineProductRepository;
use App\Shared\Application\Dto\PaginatedCollection;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\Shared\Domain\ValueObject\Money\Price;
use App\Shared\Infrastructure\Service\Pagination\PaginationFactory;
use Pagerfanta\Pagerfanta;
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
        $productRepository = $this->createMock(DoctrineProductRepository::class);
        $productRepository->expects(self::once())
            ->method('findAllQueryBuilder');

        $pagerfantaPaginator = $this->createMock(Pagerfanta::class);
        $pagerfantaPaginator->expects(self::once())
            ->method('getCurrentPageResults')
            ->willReturn($products);
        $pagerfantaPaginator->expects(self::once())
            ->method('getNbResults')
            ->willReturn(count($products));

        /** @var MockObject|PaginationFactory $paginationFactory */
        $paginationFactory = $this->createMock(PaginationFactory::class);
        $paginationFactory->expects(self::once())
            ->method('createPaginator')
            ->willReturn($pagerfantaPaginator);


        $query = new ListProductsQuery(1);
        $handler = new ListProductsQueryHandler($productRepository, $paginationFactory);

        /** @var PaginatedCollection $productsDto */
        $paginatedCollection = $handler($query);

        self::assertCount(2, $paginatedCollection->getItems());
        self::assertSame(2, $paginatedCollection->getTotal());

        self::assertSame($product1->id()->toString(), $paginatedCollection->getItems()[0]->getId());
        self::assertSame($product1->name(), $paginatedCollection->getItems()[0]->getName());
        self::assertSame($product1->price()->getValue(), $paginatedCollection->getItems()[0]->getPrice());

        self::assertSame($product2->id()->toString(), $paginatedCollection->getItems()[1]->getId());
        self::assertSame($product2->name(), $paginatedCollection->getItems()[1]->getName());
        self::assertSame($product2->price()->getValue(), $paginatedCollection->getItems()[1]->getPrice());
    }
}