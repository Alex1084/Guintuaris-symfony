<?php

namespace App\Repository;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorPieceCharacter;
use App\Entity\ArmorType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

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

    public function findArmorPiecesCharacterByCharacter($characterId)
    {
        $query = $this->createQueryBuilder("apc")
        ->select("apc.id, apc.effect, ap.value, al.name AS locationName, al.varName AS locationVarName, at.name AS typeName")
        ->join(ArmorPiece::class, "ap", JOIN::WITH, "ap.id = apc.piece")
        ->join(ArmorLocation::class, "al", JOIN::WITH, "al.id = ap.location")
        ->join(ArmorType::class, "at", JOIN::WITH, "at.id = ap.type")
        ->where("apc.charact = :character")
        ->setParameter("character", $characterId)
        ->orderBy("apc.id")
        ;
        return $query->getQuery()->getResult();
    }
}
