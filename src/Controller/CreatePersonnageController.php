<?php

namespace App\Controller;

use App\Entity\Arme;
use App\Entity\ArmePersonnage;
use App\Entity\Equipe;
use App\Entity\Personnage;
use App\Entity\PieceArmurePersonnage;
use App\Form\PersonnageType;
use App\Repository\PieceArmureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePersonnageController extends AbstractController
{
    /**
     * @Route("/personnage/creation", name="personnage_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, PieceArmureRepository $repoEquipement): Response
    {  
        // requete pour recuperer l'equipe n°5  nom -> aucune
        $id = 5;
        $repo = $this->getDoctrine()->getRepository(Equipe::class);
        $equipe = $repo->find($id);


        $personnage = new Personnage();
        $personnageForm = $this->createForm(PersonnageType::class, $personnage);

        //annulation affichage champs hors formulaire
        $personnageForm->remove('lore');
        $personnageForm->remove('inventaire');
        $personnageForm->remove('po');
        $personnageForm->remove('joueur');
        $personnageForm->remove('pv');
        $personnageForm->remove('pc');
        $personnageForm->remove('pm');
        
        //
         $personnageForm->handleRequest($request);
         if($personnageForm->isSubmitted()){
            // hydratation des champs 
            $personnage->setLore("");
             $personnage->setInventaire("");
             $personnage->setPo(0);
             $personnage->setJoueur($this->getUser());
             $personnage->setPv($personnage->getPvMax());
             $personnage->setPm($personnage->getPmMax());
             $personnage->setPc($personnage->getPcMax());
             $personnage->setEquipe($equipe);
            //

            // execution de la requete
            $entityManager->persist($personnage);
            $entityManager->flush();
            //
            
            for($i = 1; $i <= 7; $i++){
                $this->insertPiece($personnage, $i, $repoEquipement ,$entityManager);
            }

            for($i = 1; $i <= 3; $i++){
                $this->insertArme($personnage, $i, $entityManager);
            }


            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_view', ["id" => $personnage->getId()]);
        }
        return $this->render('personnage/creation.html.twig', [
            "personnageForm" => $personnageForm->createView()
        ]);
    }

    private function insertPiece($personnage, $numEmplacement, PieceArmureRepository $repoEquipement, EntityManagerInterface $entityManager){
        $piecePersonnage = new PieceArmurePersonnage();
        $piecePersonnage->setPersonnage($personnage);
        $piecePersonnage->setid($numEmplacement);
        $piecePersonnage->setPiece($repoEquipement->getArmurebyTypeEmplacement(12,$numEmplacement)); //  12 : type enlever et $i : emplacement
        
        $entityManager->persist($piecePersonnage);
        $entityManager->flush();

    }

    private function insertArme($personnage, $id, EntityManagerInterface $entityManager){
        $armePersonnage = new ArmePersonnage();
        $armePersonnage->setId($id);
        $armePersonnage->setPersonnage($personnage);
        $armePersonnage->setArme($this->getDoctrine()->getRepository(Arme::class)->find(17));

        //dump($armePersonnage);
        $entityManager->persist($armePersonnage);
        $entityManager->flush();
    }
}
