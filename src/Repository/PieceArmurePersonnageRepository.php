<?php

namespace App\Repository;

use App\Entity\Personnage;
use App\Entity\PieceArmure;
use App\Entity\PieceArmurePersonnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method PieceArmurePersonnage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PieceArmurePersonnage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PieceArmurePersonnage[]    findAll()
 * @method PieceArmurePersonnage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PieceArmurePersonnageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceArmurePersonnage::class);
    }

    //**
    //  * @return PieceArmurePersonnage[] Returns an array of PieceArmurePersonnage objects
    //  */
    
   /*  public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    } */
    

    /*
    public function findOneBySomeField($value): ?PieceArmurePersonnage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function isertNewEquipement(int $idPersonnage, PieceArmureRepository $piecerepo) {

       /*  $piece = $piecerepo->getArmurebyType(12);
        for ($i = 1; $i<=7; $i++) {
            
            $repo= $this->getDoctrine()->getRepository(PieceArmure::class);
            $piece = $repo->findOneBy(["type_id" => "17", "localisation_id" => $i]);  *///17 est l'id de type Elever $i represente la localisation allant de 1 a 7;
            //dump($piece);
            //$dql = "INSERT INTO `pieace_armure_personnage` VALUES (".$idPersonnage.", ".$i.", NULL)";
            //$entityManager->persist($dql);
            //$entityManager->flush();
            //$query->executeQuery($dql);
        //}
        //return $fullEquipement;
    }
}
