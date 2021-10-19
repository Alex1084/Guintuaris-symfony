<?php

namespace App\Repository;

use App\Entity\PieceArmurePersonnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PieceArmurePersonnage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceArmurePersonnage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceArmurePersonnage[]    findAll()
 * @method PieceArmurePersonnage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceArmurePersonnageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceArmurePersonnage::class);
    }
}
