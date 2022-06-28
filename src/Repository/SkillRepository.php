<?php

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 *
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

    public function add(Skill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Skill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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

    public function skillList(string $search = null)
    {
        $query = $this->createQueryBuilder('s')
        ->select('s.id, s.name, s.cost, s.level, c.name AS className')
        ->innerJoin(Classes::class, 'c', Join::WITH, 'c.id = s.class')
        ->where('s.name LIKE :search')
        ->setParameter('search', '%'.$search.'%');
        return $query->getQuery()->getResult();
    }
}
