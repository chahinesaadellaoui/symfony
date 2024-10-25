<?php

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<medecin>
 */
class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }



    public function countMedecinsByHospital(int $hospitalId): int
    {
        return $this->getEntityManager()
            ->createQuery("SELECT COUNT(m.id) FROM App\Entity\Medecin m JOIN m.hopital h WHERE h.id = :hospitalId")
            ->setParameter('hospitalId', $hospitalId)
            ->getSingleScalarResult();
    }

    public function findMedecinsByHospital(int $hospitalId)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT m FROM App\Entity\Medecin m JOIN m.hopital h WHERE h.id = :hospitalId ORDER BY m.id DESC")
            ->setParameter('hospitalId', $hospitalId)
            ->getResult();
    }
    
}
