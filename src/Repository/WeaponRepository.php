<?php

namespace App\Repository;

use App\Entity\Weapon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weapon>
 *
 * @method Weapon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weapon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weapon[]    findAll()
 * @method Weapon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weapon::class);
    }

    public function add(Weapon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Weapon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function optionType()
    {
        // dd($this->createQueryBuilder('w')
        // ->orderBy('w.name', 'ASC')
        // ->getQuery()->getResult());
        return $this->createQueryBuilder('w')
                    ->orderBy('w.name', 'ASC');
                    // ->getQuery()->getResult();
    }

    public function findEmpty()
    {
        $empty = "Vide";
        return $this->createQueryBuilder('w')
                    ->where("w.name = :empty")
                    ->setParameter("empty", $empty)
                    ->orderBy('w.name', 'ASC')
                    ->getQuery()->getResult();
    }
}
