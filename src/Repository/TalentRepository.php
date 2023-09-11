<?php

namespace App\Repository;

use App\Entity\Statistic;
use App\Entity\Talent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Talent>
 *
 * @method Talent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Talent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Talent[]    findAll()
 * @method Talent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TalentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Talent::class);
    }

    public function add(Talent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Talent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTalentNotInPlayerInfos($ids)
    {
        // if user haven't talents select all
        if (empty($ids)) {
            $ids = 0; // array can't be empty so set false value
        }
        return $this->createQueryBuilder("t")
        ->select("t.name, t.id")
        ->where("t.id NOT IN (:ids)")
        ->setParameter("ids", $ids)
        ->getQuery()
        ->getResult()
        ;
    }
    public function findAllNames()
    {
        return $this->createQueryBuilder("t")
        ->select("t.name, t.id, s.id as statistic_id")
        ->join(Statistic::class, 's', Join::WITH, "t.statistic = s.id")
        ->getQuery()
        ->getResult()
        ;
    }
}
