<?php

namespace App\Repository;

use App\Entity\DirectionCentrale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DirectionCentrale|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirectionCentrale|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirectionCentrale[]    findAll()
 * @method DirectionCentrale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirectionCentraleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DirectionCentrale::class);
    }

    // /**
    //  * @return DirectionCentrale[] Returns an array of DirectionCentrale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DirectionCentrale
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
