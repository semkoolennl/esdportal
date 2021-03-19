<?php

namespace App\Eset\Infrastructure\Repository;

use App\Eset\Domain\Entity\ProductDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductDetails[]    findAll()
 * @method ProductDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductDetails::class);
    }

    // /**
    //  * @return ProductDetails[] Returns an array of ProductDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EsetProductDetails
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
