<?php

namespace App\Repository;

use App\Entity\Competence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competence[]    findAll()
 * @method Competence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competence::class);
    }


    public function findByLevel(int $level = 1, int $classe = 1)
    {
        $query = $this->createQueryBuilder('c');
        $query->where('c.niveau <= :level')->setParameter('level', $level);
        $query->andWhere('c.classe = :classe')->setParameter('classe', $classe);

        return $query->getQuery()->getResult();
    }
}
