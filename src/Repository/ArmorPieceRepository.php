<?php

namespace App\Repository;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
    public function getArmorbyLocation($locationId)
    {
        $typeName = "Enlever";
        $query = $this->createQueryBuilder('ap')
            ->innerJoin(ArmorType::class, 'at', Join::WITH, 'ap.type = at.id')
            ->where('at.name = :name')
            ->setParameter('name', $typeName)
            ->andWhere('a.location = :empla')
            ->setParameter('empla', $locationId)
            ->getQuery();
        return $query->getSingleResult();
    }

    public function selectAllNamesValue()
    {
        return $this->createQueryBuilder('ap')
            ->select('ap.id, ap.value, al.name AS locationName, at.name AS typeName')
            ->innerJoin(ArmorLocation::class, 'al', Join::WITH, 'al.id = ap.location')
            ->innerJoin(ArmorType::class, 'at', Join::WITH, 'at.id = ap.type')
            ->orderBy('at.name, al.name', 'ASC')
            ->getQuery()->getResult();
    }

    private function optionType(int $id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.location = :id')
            ->setParameter("id", $id);
    }
}
