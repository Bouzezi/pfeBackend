<?php

namespace App\Repository;

use App\Entity\ProgrammeCooperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgrammeCooperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgrammeCooperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgrammeCooperation[]    findAll()
 * @method ProgrammeCooperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammeCooperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgrammeCooperation::class);
    }

    // /**
    //  * @return ProgrammeCooperation[] Returns an array of ProgrammeCooperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProgrammeCooperation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
