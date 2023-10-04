<?php

namespace App\Repository;

use App\Entity\ArmorType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArmorType>
 *
 * @method ArmorType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorType[]    findAll()
 * @method ArmorType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorType::class);
    }
}
