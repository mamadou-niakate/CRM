<?php

namespace App\Repository;

use App\Entity\OpportunityStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OpportunityStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpportunityStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpportunityStatus[]    findAll()
 * @method OpportunityStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpportunityStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpportunityStatus::class);
    }

    // /**
    //  * @return OpportunityStatus[] Returns an array of OpportunityStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OpportunityStatus
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
