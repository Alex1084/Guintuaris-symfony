<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\Team;
use App\Entity\Weapon;
use App\Entity\WeaponCharacter;
use App\Form\CharacterType;
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
     * @Route("/personnage/creation", name="create_character")
     * 
     */
    public function create(Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $armorPieceRepository): Response
    {
        // requete pour recuperer l'equipe n°5  nom -> aucune
        $id = 5;
        $repo = $this->getDoctrine()->getRepository(Team::class);
        $team = $repo->find($id);


        $character = new Character();
        $characterForm = $this->createForm(CharacterType::class, $character);

        //annulation affichage champs hors formulaire

        //
        $characterForm->handleRequest($request);
        if ($characterForm->isSubmitted()) {
            // hydratation des champs 
            $character->setGold(0)
                       ->setUser($this->getUser())
                       ->setTeam($team)
                       ->setPv($character->getPvMax())
                       ->setPm($character->getPmMax())
                       ->setPc($character->getPcMax());
            
            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();

            for ($i = 1; $i <= 7; $i++) {
                $this->insertPiece($character, $i, $armorPieceRepository, $entityManager);
            }

            for ($i = 1; $i <= 3; $i++) {
                $this->insertWeapon($character, $i, $entityManager);
            }


            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_view', ["id" => $character->getId()]);
        }
        return $this->render('personnage/creation.html.twig', [
            "characterForm" => $characterForm->createView()
        ]);
    }


    /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table armor_piece_character
     * le locationNumber est un nombre compris entre 1 et 7 (donnée par la boucle) il represente en meme temps la localisation de l'armure.
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     */
    private function insertPiece(Character $character, int $locationNumber, ArmorPieceRepository $repoArmorPiece, EntityManagerInterface $entityManager)
    {
        $armorPieceCharacter = new ArmorPieceCharacter();
        $armorPieceCharacter->setCharact($character)
                       ->setId($locationNumber)
                       ->setPiece($repoArmorPiece->getArmorbyLocation($locationNumber)); // $locationNumber : emplacement (allant de 1 a 7)

        $entityManager->persist($armorPieceCharacter);
        $entityManager->flush();
    }

    /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table arme_personnage
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     */
    private function insertWeapon(Character $character, int $id, EntityManagerInterface $entityManager)
    {
        $weaponCharacter = new WeaponCharacter();
        $weaponCharacter->setId($id)
                        ->setCharact($character)
                        ->setWeapon($this->getDoctrine()->getRepository(Weapon::class)->findOneBy(['name' => 'Vide']));

        $entityManager->persist($weaponCharacter);
        $entityManager->flush();
    }
}
