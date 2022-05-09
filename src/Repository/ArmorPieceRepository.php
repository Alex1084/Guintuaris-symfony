<?php

namespace App\Repository;

use App\Entity\ArmorPiece;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArmorPiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorPiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorPiece[]    findAll()
 * @method ArmorPiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorPieceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorPiece::class);
    }
    public function getArmorbyLocation($typeId, $empla)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.type = :type')
            ->setParameter('type', $typeId)
            ->andWhere('a.location = :empla')
            ->setParameter('empla', $empla)
            ->getQuery();
        return $query->getSingleResult();
    }
}
