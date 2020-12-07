<?php

namespace App\Repository;

use App\Entity\InteractionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InteractionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method InteractionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method InteractionStatus[]    findAll()
 * @method InteractionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteractionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InteractionStatus::class);
    }

    // /**
    //  * @return InteractionStatus[] Returns an array of InteractionStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InteractionStatus
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
