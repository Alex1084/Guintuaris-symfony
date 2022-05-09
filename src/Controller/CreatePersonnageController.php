<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Equipe;
use App\Entity\Personnage;
use App\Entity\Weapon;
use App\Entity\WeaponCharacter;
use App\Form\PersonnageType;
use App\Repository\ArmorPieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePersonnageController extends AbstractController
{
    /**
     * cette page permet de creer pour un utilisateur un nouveau personnage$
     * lors de la creation 7 nouvelle ligne sont créer dans la table armor_piece_character
     * avec comme idantifiant le personnage et un nombre allant de 1 à 7
     * et trois ligne sont créer pour les arme_personnage
     * 
     * @Route("/personnage/creation", name="personnage_create")
     * 
     */
    public function create(Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $repoArmorPiece): Response
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

        //
        $personnageForm->handleRequest($request);
        if ($personnageForm->isSubmitted()) {
            // hydratation des champs 
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

            for ($i = 1; $i <= 7; $i++) {
                $this->insertPiece($personnage, $i, $repoArmorPiece, $entityManager);
            }

            for ($i = 1; $i <= 3; $i++) {
                $this->insertWeapon($personnage, $i, $entityManager);
            }


            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_view', ["id" => $personnage->getId()]);
        }
        return $this->render('personnage/creation.html.twig', [
            "personnageForm" => $personnageForm->createView()
        ]);
    }


    /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table armor_piece_character
     * le numEmplacement est un nombre compris entre 1 et 7 (donnée par la boucle) il represente en meme temps la localisation de l'armure.
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     */
    private function insertPiece(Personnage $personnage, int $numEmplacement, ArmorPieceRepository $repoArmorPiece, EntityManagerInterface $entityManager)
    {
        $piecePersonnage = new ArmorPieceCharacter();
        $piecePersonnage->setCharact($personnage);
        $piecePersonnage->setId($numEmplacement);
        $piecePersonnage->setPiece($repoArmorPiece->getArmorbyLocation(12, $numEmplacement)); //  12 : type enlever et $numEmplacement : emplacement (allant de 1 a 7)

        $entityManager->persist($piecePersonnage);
        $entityManager->flush();
    }

    /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table arme_personnage
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     * @param Personnage $personnage
     * @param integer $id
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    private function insertWeapon(Personnage $personnage, int $id, EntityManagerInterface $entityManager)
    {
        $weaponPersonnage = new WeaponCharacter();
        $weaponPersonnage->setId($id);
        $weaponPersonnage->setCharact($personnage);
        $weaponPersonnage->setWeapon($this->getDoctrine()->getRepository(Weapon::class)->find(17));

        $entityManager->persist($weaponPersonnage);
        $entityManager->flush();
    }
}
