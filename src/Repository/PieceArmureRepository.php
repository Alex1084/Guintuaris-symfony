<?php

namespace App\Repository;

use App\Entity\PieceArmure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PieceArmure|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceArmure|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceArmure[]    findAll()
 * @method PieceArmure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceArmureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceArmure::class);
    }

    public function getArmurebyTypeEmplacement($typeId, $empla)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.type = :type')
            ->setParameter('type', $typeId)
            ->andWhere('a.localisation = :empla')
            ->setParameter('empla', $empla)
            ->getQuery();
        return $query->getSingleResult();
    }
}
