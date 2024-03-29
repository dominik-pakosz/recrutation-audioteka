<?php

namespace App\ProductCatalog\Infrastructure\Repository;

use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\Identity\Uuid\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('product');
    }

    public function findOneById(ProductId $id): ?Product
    {
        return $this->createQueryBuilder('product')
            ->where('product.id = :productId')
            ->setParameter('productId', $id->toString())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @inheritDoc */
    public function findAllByIds(array $productIds): array
    {
        $productIdsAsString = [];
        foreach ($productIds as $productId) {
            $productIdsAsString[] = $productId->toString();
        }

        return $this->createQueryBuilder('product')
            ->where('product.id IN (:productIds)')
            ->setParameter('productIds', $productIdsAsString)
            ->getQuery()
            ->getResult();
    }
}
