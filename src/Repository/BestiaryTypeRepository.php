<?php

namespace App\Repository;

use App\Entity\BestiaryType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BestiaryType>
 *
 * @method BestiaryType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BestiaryType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BestiaryType[]    findAll()
 * @method BestiaryType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestiaryTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BestiaryType::class);
    }
}
