<?php

namespace App\Eset\Infrastructure\Repository;

use App\Eset\Domain\Entity\CompanyProductDetailsLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyProductDetailsLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyProductDetailsLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyProductDetailsLink[]    findAll()
 * @method CompanyProductDetailsLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyProductDetailsLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyProductDetailsLink::class);
    }

    // /**
    //  * @return CompanyProductDetailsLink[] Returns an array of CompanyProductDetailsLink objects
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
    public function findOneBySomeField($value): ?CompanyProductDetailsLink
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
