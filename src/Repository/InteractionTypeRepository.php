<?php

namespace App\Repository;

use App\Entity\InteractionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InteractionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method InteractionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method InteractionType[]    findAll()
 * @method InteractionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteractionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InteractionType::class);
    }

    // /**
    //  * @return InteractionType[] Returns an array of InteractionType objects
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
    public function findOneBySomeField($value): ?InteractionType
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
