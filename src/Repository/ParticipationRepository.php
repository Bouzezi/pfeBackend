<?php

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\HYDRATE_ARRAY;

/**
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    /**
     * @return CadreINS[]
     */
    public function findAllCadreParticipe(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c.id
            FROM App\Entity\Participation p
            INNER JOIN
            p.cadre 
            LEFT JOIN
                App\Entity\CadreINS c
            GROUP BY c.id'
        );

        // returns an array of Cadre objects
        return $query->getResult();
    }
    public function findAllAnnee(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.annee
            FROM App\Entity\Participation p
            GROUP BY p.annee
            ORDER BY p.annee DESC'
        );

        // returns an array of annee objects
        return $query->getResult();
    }
   

    public function cadreParAnnee($annee,$cadre): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(p.dossier_id) as nombreDossier  FROM participation p , dossier_visite d , cadre_ins c
            WHERE p.cadre_id = c.id AND p.dossier_id = d.id
            AND p.cadre_id = :cad AND p.annee = :an
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['cad' => $cadre , 'an' => $annee]);

        return $stmt->fetchAll();
    }
    public function statParOrganisme($annee,$cadre,$dossier): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(p.dossier_id) as nombreDossier  FROM participation p , dossier_visite d , cadre_ins c
            WHERE p.cadre_id = c.id AND p.dossier_id = d.id
            AND p.cadre_id = :cad AND p.annee = :an AND p.dossier_id = :dos
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['cad' => $cadre , 'an' => $annee, 'dos' => $dossier]);

        return $stmt->fetchAll();
    }

   
}
