<?php

namespace App\Repository;

use App\Entity\Classes;
use App\Entity\DurationType;
use App\Entity\Resource;
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
        ->select('s.name, s.distance, s.damage, s.duration, dt.label, s.radius, s.description, s.level, s.cost, r.symbol')
        ->join(DurationType::class, 'dt', Join::WITH, 'dt.id = s.durationType')
        ->join(Resource::class, 'r', Join::WITH, 'r.id = s.resource')
        ->where('s.level <= :level')
        ->andWhere('s.class = :class')
        ->setParameter('class', $class)
        ->setParameter('level', $level)
        ->orderBy("s.level, s.name");

        return $query->getQuery()->getResult();
    }

    public function skillList(string $search = null)
    {
        $query = $this->createQueryBuilder('s')
        ->select('s.id, s.name, s.cost, s.level, c.name AS className')
        ->innerJoin(Classes::class, 'c', Join::WITH, 'c.id = s.class')
        ->where('s.name LIKE :search')
        ->setParameter('search', '%'.$search.'%')
        ->orderBy("c.name, s.level, s.name");
        return $query->getQuery()->getResult();
    }

    public function findByClass(int $classId)
    {
        return $this->createQueryBuilder('s')
        ->select('s.name, s.distance, s.damage, s.duration, dt.label, s.radius, s.description, s.level, s.cost, r.symbol')
        ->join(DurationType::class, 'dt', Join::WITH, 'dt.id = s.durationType')
        ->join(Resource::class, 'r', Join::WITH, 'r.id = s.resource')
        ->where("s.class = :classId")
        ->setParameter("classId", $classId)
        ->orderBy("s.level, s.name")
        ->getQuery()->getResult();
    }
}
