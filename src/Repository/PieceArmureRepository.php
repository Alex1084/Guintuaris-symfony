<?php

namespace App\Repository;

use App\Entity\PieceArmure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PieceArmure|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceArmure|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceArmure[]    findAll()
 * @method PieceArmure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceArmureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceArmure::class);
    }

    // /**
    //  * @return PieceArmure[] Returns an array of PieceArmure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PieceArmure
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
