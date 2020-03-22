<?php

namespace App\ShoppingCart\Infrastructure\Repository;

use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCartRepository extends ServiceEntityRepository implements CartRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findOneByUserId(UserId $userId): ?Cart
    {
        return $this->createQueryBuilder('cart')
            ->where('cart.user_id = :userId')
            ->setParameter('userId', $userId->toString())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
