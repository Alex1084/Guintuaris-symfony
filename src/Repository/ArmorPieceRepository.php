<?php

namespace App\Repository;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join as Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArmorPiece>
 *
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

    public function add(ArmorPiece $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArmorPiece $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findEmptybyLocation($locationId)
    {
        $typeName = "Enlever";
        $query = $this->createQueryBuilder('ap')
            ->innerJoin(ArmorType::class, 'at', Join::WITH, 'ap.type = at.id')
            ->where('at.name = :name')
            ->setParameter('name', $typeName)
            ->andWhere('ap.location = :empla')
            ->setParameter('empla', $locationId)
            ->getQuery();
        return $query->getResult();
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

    public function optionType(int $id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.location = :id')
            ->setParameter("id", $id)
            ->orderBy("p.id", "asc");
    }
}
