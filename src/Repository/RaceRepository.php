<?php

namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Race>
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }

    public function add(Race $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Race $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function raceList()
    {
        return $query = $this->createQueryBuilder('r')
            ->select('r.id, r.slug, r.name')
            ->orderBy("r.name")
            ->getQuery()->getResult();
    }
}
