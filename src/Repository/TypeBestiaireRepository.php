<?php

namespace App\Repository;

use App\Entity\TypeBestiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBestiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBestiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBestiaire[]    findAll()
 * @method TypeBestiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBestiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBestiaire::class);
    }

    // /**
    //  * @return TypeBestiaire[] Returns an array of TypeBestiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeBestiaire
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
