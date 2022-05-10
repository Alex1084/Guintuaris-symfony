<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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
}
