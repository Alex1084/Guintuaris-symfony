<?php

namespace App\Repository;

use App\Entity\ArmorPieceCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArmorPieceCharacter>
 *
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
}
