<?php

namespace App\Repository;

use App\Entity\Arme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Arme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arme[]    findAll()
 * @method Arme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arme::class);
    }
}
