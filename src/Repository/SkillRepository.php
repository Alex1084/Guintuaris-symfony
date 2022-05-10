<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }


    public function findByLevel(int $level, int $class)
    {
        $query = $this->createQueryBuilder('s')
        ->where('s.level <= :level')
        ->andWhere('s.class = :class')
        ->setParameter('class', $class)
        ->setParameter('level', $level);

        return $query->getQuery()->getResult();
    }
}
