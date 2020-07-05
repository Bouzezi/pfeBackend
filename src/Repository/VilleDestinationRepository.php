<?php

namespace App\Repository;

use App\Entity\VilleDestination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VilleDestination|null find($id, $lockMode = null, $lockVersion = null)
 * @method VilleDestination|null findOneBy(array $criteria, array $orderBy = null)
 * @method VilleDestination[]    findAll()
 * @method VilleDestination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleDestinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VilleDestination::class);
    }

    // /**
    //  * @return VilleDestination[] Returns an array of VilleDestination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VilleDestination
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
