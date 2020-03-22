<?php

namespace App\ShoppingCart\Infrastructure\Repository;

use App\Shared\Domain\ValueObject\Identity\Uuid\UserId;
use App\ShoppingCart\Domain\Exception\CartNotFoundException;
use App\ShoppingCart\Domain\Model\Cart;
use App\ShoppingCart\Domain\Repository\CartRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineCartRepository extends ServiceEntityRepository implements CartRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function findOneByUserId(UserId $userId): ?Cart
    {
        $cart = $this->createQueryBuilder('cart')
            ->where('cart.userId = :userId')
            ->setParameter('userId', $userId->toString())
            ->getQuery()
            ->getOneOrNullResult();

        if (!$cart) {
            throw CartNotFoundException::forUserId($userId);
        }

        return $cart;
    }
}
