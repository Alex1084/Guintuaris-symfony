<?php

namespace App\Repository;

use App\Entity\ArmorPieceCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArmorPieceCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArmorPieceCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArmorPieceCharacter[]    findAll()
 * @method ArmorPieceCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmorPieceCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArmorPieceCharacter::class);
    }

    // /**
    //  * @return ArmorPieceCharacter[] Returns an array of ArmorPieceCharacter objects
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
    public function findOneBySomeField($value): ?ArmorPieceCharacter
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
