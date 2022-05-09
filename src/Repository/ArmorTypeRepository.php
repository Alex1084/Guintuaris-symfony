<?php

namespace App\Repository;

use App\Entity\ArmorType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArmorType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorType[]    findAll()
 * @method ArmorType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorType::class);
    }

    // /**
    //  * @return ArmorType[] Returns an array of ArmorType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArmorType
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
