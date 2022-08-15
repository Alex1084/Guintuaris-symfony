<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function add(Character $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Character $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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

    public function findNameByTeam(int $teamId)
    {
        return $this->createQueryBuilder('c')
        ->select('c.id, c.name, c.slug')
        ->where('c.team = :team')
        ->setParameter('team', $teamId)
        ->orderBy('c.name', 'ASC')
        ->getQuery()->getResult();
    }

    public function listByUser(int $userId)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, c.image, c.slug')
            ->where('c.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('c.name', 'ASC')
            ->getQuery()->getResult();

    }

}
