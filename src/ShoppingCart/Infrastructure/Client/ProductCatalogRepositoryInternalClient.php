<?php

namespace App\ShoppingCart\Infrastructure\Client;

use App\ProductCatalog\Domain\Model\Product as ProductCatalogProduct;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use App\ShoppingCart\Domain\Client\ProductCatalogClient;
use App\ShoppingCart\Domain\Exception\ProductNotFoundException;
use App\ShoppingCart\Domain\Model\Product as ShoppingCartProduct;

class ProductCatalogRepositoryInternalClient implements ProductCatalogClient
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductByProductId(ProductId $productId): ShoppingCartProduct
    {
        /** @var ProductCatalogProduct $fetchedData */
        $fetchedData = $this->productRepository->findOneById($productId);

        if (!$fetchedData) {
            throw ProductNotFoundException::byProductId($productId);
        }

        return ShoppingCartProduct::recreate(
            $fetchedData->id(),
            $fetchedData->name(),
            $fetchedData->price()
        );
    }
}
