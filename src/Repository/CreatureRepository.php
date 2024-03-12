<?php

namespace App\Repository;

use App\Entity\Creature;
use App\Entity\CreatureType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Creature>
 *
 * @method Creature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creature[]    findAll()
 * @method Creature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creature::class);
    }

    public function bestiaryList(string $search = null)
    {
        $query = $this->createQueryBuilder('c')
        ->select('c.id, c.name, c.level, ct.name AS typeName')
        ->innerJoin(CreatureType::class, 'ct', Join::WITH, 'ct.id = c.type')
        ->where('c.name LIKE :search')
        ->setParameter('search', '%'.$search.'%');
        return $query->getQuery()->getResult();
    }

    public function getAllName()
    {
        $query = $this->createQueryBuilder('c')
        ->select("ct.id as typeID, c.id, c.name")
        ->innerJoin(CreatureType::class, 'ct', Join::WITH, 'ct.id = c.type')
        ->orderBy("c.name");

        return $query->getQuery()->getResult();
    }
}
