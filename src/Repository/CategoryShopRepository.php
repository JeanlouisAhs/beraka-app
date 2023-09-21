<?php

namespace App\Repository;

use App\Entity\CategoryShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryShop>
 *
 * @method CategoryShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryShop[]    findAll()
 * @method CategoryShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryShop::class);
    }

//    /**
//     * @return CategoryShop[] Returns an array of CategoryShop objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryShop
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
