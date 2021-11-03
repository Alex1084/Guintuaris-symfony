<?php

namespace App\Repository;

use App\Entity\TypeArmure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeArmure|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeArmure|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeArmure[]    findAll()
 * @method TypeArmure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeArmureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeArmure::class);
    }
}
