<?php

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 *
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function updateInventaire($id, $inventory, $gold)
    {
        $this->createQueryBuilder('c')
        ->update(Character::class, 'c')
        ->set('c.inventory', ':inventory')
        ->set('c.gold', ':gold')
        ->where('c.id = :id')
        ->setParameter('inventory', $inventory)
        ->setParameter('gold', $gold)
        ->setParameter('id', $id)
        ->getQuery()->execute();
    }

    public function findNameByTeam(int $teamId, int $userId = 0, int $characterId = 0)
    {
        return $this->createQueryBuilder('c')
        ->select('c.id, c.name, c.slug, c.image, c.level')
        ->where('c.team = :team')
        ->setParameter('team', $teamId)
        ->andWhere('c.user <> :user')
        ->setParameter('user', $userId)
        ->andWhere('c.id <> :character')
        ->setParameter('character', $characterId)
        ->orderBy('c.name', 'ASC')
        ->getQuery()->getResult();
    }

    public function listByUser(int $userId)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, c.image, c.slug, c.level, t.name as teamName, t.id as teamId, t.slug as teamSlug')
            ->leftJoin(Team::class, 't', Join::WITH, "t.id = c.team")
            ->where('c.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('c.last_view', 'DESC')
            ->getQuery()->getResult();

    }

    public function findAllName()
    {
        return $this->createQueryBuilder('c')
                    ->select("c.id, c.slug, c.name, c.level, c.image, u.name as userName, u.id as userId, t.id as teamId, t.slug as teamSlug, t.name as teamName")
                    ->join(User::class, "u", Join::WITH, "u.id = c.user")
                    ->leftJoin(Team::class, "t", Join::WITH, "t.id = c.team")
                    ->orderBy("c.name")
                    ->getQuery()->getResult();
                    ;
    }

}
