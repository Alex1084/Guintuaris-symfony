<?php

namespace App\Repository;

use App\Entity\ArmorLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArmorLocation>
 *
 * @method ArmorLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorLocation[]    findAll()
 * @method ArmorLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorLocation::class);
    }

    public function add(ArmorLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ArmorLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllName()
    {
        return $this->createQueryBuilder("al")
        ->select("al.name")->getQuery()->getResult();
    }

//    /**
//     * @return ArmorLocation[] Returns an array of ArmorLocation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArmorLocation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
