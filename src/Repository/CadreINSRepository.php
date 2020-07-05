<?php

namespace App\Repository;

use App\Entity\CadreINS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadreINS|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadreINS|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadreINS[]    findAll()
 * @method CadreINS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadreINSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadreINS::class);
    }

    // /**
    //  * @return CadreINS[] Returns an array of CadreINS objects
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
    public function findOneBySomeField($value): ?CadreINS
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
