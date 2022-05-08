<?php

namespace App\Repository;

use App\Entity\Personnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personnage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnage[]    findAll()
 * @method Personnage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnage::class);
    }

    public function updateInventaire($id, $inventaire, $po)
    {
        $this->createQueryBuilder('p')
        ->update(Personnage::class, 'p')
        ->set('p.inventaire', ':inventaire')
        ->set('p.po', ':po')
        ->where('p.id = :id')
        ->setParameter('inventaire', $inventaire)
        ->setParameter('po', $po)
        ->setParameter('id', $id)
        ->getQuery()->execute();
    }
}
