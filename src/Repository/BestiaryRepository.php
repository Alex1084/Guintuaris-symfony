<?php

namespace App\Repository;

use App\Entity\Bestiary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bestiary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bestiary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bestiary[]    findAll()
 * @method Bestiary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestiaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bestiary::class);
    }

    public function findAllName(int $type)
    {
        $entityManager = $this->getEntityManager();
        $dql = "SELECT b.id, b.name FROM App\Entity\Bestiary b WHERE b.type = :type ORDER BY b.name";
        $query = $entityManager->createQuery($dql)->setParameter('type', $type);
        return $query->getResult();
    }
}
