<?php

namespace App\Repository;

use App\Entity\LocalisationArmure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LocalisationArmure|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocalisationArmure|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocalisationArmure[]    findAll()
 * @method LocalisationArmure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalisationArmureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocalisationArmure::class);
    }
}
