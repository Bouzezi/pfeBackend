<?php

namespace App\Repository;

use App\Entity\OrganismeEtranger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrganismeEtranger|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganismeEtranger|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganismeEtranger[]    findAll()
 * @method OrganismeEtranger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganismeEtrangerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganismeEtranger::class);
    }

    // /**
    //  * @return OrganismeEtranger[] Returns an array of OrganismeEtranger objects
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
    public function findOneBySomeField($value): ?OrganismeEtranger
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
