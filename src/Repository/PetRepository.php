<?php

namespace App\Repository;

use App\Entity\Pet;
use App\Entity\Character;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Pet>
 *
 * @method Pet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pet[]    findAll()
 * @method Pet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

    public function listByUser(int $userId)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, p.image, p.slug, p.level, c.name as characterName, c.id as characterId, c.slug as characterSlug')
            ->leftJoin(Character::class, 'c', Join::WITH, "c.id = p.owner")
            ->where('c.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()->getResult();

    }
}
