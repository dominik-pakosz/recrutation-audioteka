<?php

namespace App\ProductCatalog\Infrastructure\Repository;

use App\ProductCatalog\Domain\Model\Product;
use App\ProductCatalog\Domain\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
//
//    public function findAllByUserOrderedByCreationDateDesc(UserId $userId): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.userId = :userId')
//            ->orderBy('a.createdAt', 'DESC')
//            ->setParameter('userId', $userId->toString())
//            ->getQuery()
//            ->getResult();
//    }
//
//    public function sumBusinessDays(AbsenceType $type, UserId $userId): int
//    {
//        $sum = $this->createQueryBuilder('a')
//            ->select('SUM(a.businessDays)')
//            ->where('a.userId = :userId')
//            ->andWhere('a.type.value = :type')
//            ->setParameters([
//                'userId' => $userId->toString(),
//                'type' => $type->toString(),
//            ])
//            ->getQuery()
//            ->getSingleScalarResult();
//
//        if (!$sum) {
//            return 0;
//        }
//
//        return $sum;
//    }
}
