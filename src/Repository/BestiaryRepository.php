<?php

namespace App\Repository;

use App\Entity\Bestiary;
use App\Entity\BestiaryType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bestiary>
 *
 * @method Bestiary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bestiary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bestiary[]    findAll()
 * @method Bestiary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestiaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bestiary::class);
    }

    public function add(Bestiary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bestiary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function bestiaryList(string $search = null)
    {
        $query = $this->createQueryBuilder('b')
        ->select('b.id, b.name, b.level, bt.name AS typeName')
        ->innerJoin(BestiaryType::class, 'bt', Join::WITH, 'bt.id = b.type')
        ->where('b.name LIKE :search')
        ->setParameter('search', '%'.$search.'%');
        return $query->getQuery()->getResult();
    }
}
