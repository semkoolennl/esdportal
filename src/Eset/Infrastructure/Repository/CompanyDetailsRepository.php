<?php

namespace App\Eset\Infrastructure\Repository;

use App\Eset\Domain\Entity\CompanyDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyDetails[]    findAll()
 * @method CompanyDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyDetails::class);
    }

    // /**
    //  * @return Company[] Returns an array of Company objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Company
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
