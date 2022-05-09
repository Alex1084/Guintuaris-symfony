<?php

namespace App\Repository;

use App\Entity\Bestiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bestiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bestiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bestiaire[]    findAll()
 * @method Bestiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bestiaire::class);
    }

    public function findAllName(int $type)
    {
        $entityManager = $this->getEntityManager();
        $dql = "SELECT b.id, b.name FROM App\Entity\Bestiaire b WHERE b.type = :type ORDER BY b.name";
        $query = $entityManager->createQuery($dql)->setParameter('type', $type);
        return $query->getResult();
    }
}
