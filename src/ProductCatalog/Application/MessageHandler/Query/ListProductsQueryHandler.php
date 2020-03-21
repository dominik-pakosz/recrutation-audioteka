<?php

namespace App\ProductCatalog\Application\MessageHandler\Query;

use App\ProductCatalog\Application\Dto\Product as ProductDto;
use App\ProductCatalog\Application\Dto\Products as ProductsDto;
use App\ProductCatalog\Application\Message\Query\ListProductsQuery;
use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListProductsQueryHandler implements MessageHandlerInterface
{
    /**  @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductsQuery $command): ProductsDto
    {
        /** @var Product[] $products */
        $products = $this->productRepository->findAll();

        $productsDto = new ProductsDto();
        foreach ($products as $product) {
            $productsDto->add(
                new ProductDto(
                    $product->id()->toString(),
                    $product->name(),
                    $product->price()->getValue()
                )
            );
        }

        return $productsDto;
    }
}
