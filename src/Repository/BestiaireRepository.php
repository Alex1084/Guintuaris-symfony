<?php

namespace App\Repository;

use App\Entity\Bestiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bestiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bestiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bestiaire[]    findAll()
 * @method Bestiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bestiaire::class);
    }

    // /**
    //  * @return Bestiaire[] Returns an array of Bestiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bestiaire
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
