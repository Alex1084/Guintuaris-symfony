<?php

namespace App\Repository;

use App\Entity\Fiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche[]    findAll()
 * @method Fiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche::class);
    }

    public function updateStatus($id, $pv, $pc, $pm)
    {
        $this->createQueryBuilder('f')
        ->update(Fiche::class, 'f')
        ->set('f.pv', ':pv')
        ->set('f.pc', ':pc')
        ->set('f.pm', ':pm')
        ->where('f.id = :id')
        ->setParameter('pv', $pv)
        ->setParameter('pc', $pc)
        ->setParameter('pm', $pm)
        ->setParameter('id', $id)
        ->getQuery()->execute();        
    }
}
