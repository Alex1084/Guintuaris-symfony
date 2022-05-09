<?php

namespace App\Repository;

use App\Entity\WeaponCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeaponCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeaponCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeaponCharacter[]    findAll()
 * @method WeaponCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaponCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeaponCharacter::class);
    }

    // /**
    //  * @return WeaponCharacter[] Returns an array of WeaponCharacter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeaponCharacter
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
