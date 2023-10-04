<?php

namespace App\Repository;

use App\Entity\DurationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DurationType>
 *
 * @method DurationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DurationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DurationType[]    findAll()
 * @method DurationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DurationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DurationType::class);
    }
}
