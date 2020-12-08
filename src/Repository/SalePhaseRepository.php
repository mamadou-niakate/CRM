<?php

namespace App\Repository;

use App\Entity\SalePhase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalePhase|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalePhase|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalePhase[]    findAll()
 * @method SalePhase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalePhaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalePhase::class);
    }

    // /**
    //  * @return SalePhase[] Returns an array of SalePhase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalePhase
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
