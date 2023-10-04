<?php

namespace App\Repository;

use App\Entity\ArmorLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArmorLocation>
 *
 * @method ArmorLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorLocation[]    findAll()
 * @method ArmorLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorLocation::class);
    }

    public function findAllName()
    {
        return $this->createQueryBuilder("al")
        ->select("al.name")->getQuery()->getResult();
    }
}
