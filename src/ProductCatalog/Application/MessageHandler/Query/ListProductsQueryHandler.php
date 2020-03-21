<?php

namespace App\ProductCatalog\Application\MessageHandler\Query;

use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\ProductCatalog\Infrastructure\Repository\DoctrineProductRepository;
use App\Shared\Application\Dto\PaginatedCollection;
use App\Shared\Infrastructure\Service\Pagination\PaginationFactory;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListProductsQueryHandler implements MessageHandlerInterface
{
    /**  @var DoctrineProductRepository */
    private $productRepository;

    /** @var PaginationFactory */
    private $paginationFactory;

    public function __construct(ProductRepository $productRepository, PaginationFactory $paginationFactory)
    {
        $this->productRepository = $productRepository;
        $this->paginationFactory = $paginationFactory;
    }

    public function __invoke(ListProductsQuery $command): PaginatedCollection
    {
        /** @var Product[] $products */
        $queryBuilder = $this->productRepository->findAllQueryBuilder();

        $paginator = $this->paginationFactory->createPaginator(
            $queryBuilder,
            $command->getPage()
        );

        $products = [];
        /** @var Product $result */
        foreach ($paginator->getCurrentPageResults() as $result) {
            $products[] = new ProductDto(
                $result->id()->toString(),
                $result->name(),
                $result->price()->getValue()
            );
        }

        return new PaginatedCollection($products, $paginator->getNbResults());
    }
}
