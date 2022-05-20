<?php

namespace App\Repository;

use App\Entity\Sheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sheet>
 *
 * @method Sheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sheet[]    findAll()
 * @method Sheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sheet::class);
    }

    public function add(Sheet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sheet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function updateStatus($id, $pv, $pc, $pm)
    {
        $this->createQueryBuilder('s')
        ->update(Sheet::class, 's')
        ->set('s.pv', ':pv')
        ->set('s.pc', ':pc')
        ->set('s.pm', ':pm')
        ->where('s.id = :id')
        ->setParameter('pv', $pv)
        ->setParameter('pc', $pc)
        ->setParameter('pm', $pm)
        ->setParameter('id', $id)
        ->getQuery()->execute();        
    }
}
