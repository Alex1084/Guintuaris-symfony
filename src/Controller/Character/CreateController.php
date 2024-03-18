<?php

namespace App\Controller\Character;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\WeaponCharacter;
use App\Form\CharacterType;
use App\Repository\ArmorLocationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreateController extends AbstractController
{
    /**
     * cette page permet de creer pour un utilisateur un nouveau personnage$
     * lors de la creation 7 nouvelle ligne sont créer dans la table armor_piece_character
     * avec comme idantifiant le personnage et un nombre allant de 1 à 7
     * et trois ligne sont créer pour les arme_personnage
     */
    #[Route('/personnage/creation', name: 'create_character')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger): Response
    {
        $character = new Character();
        $characterForm = $this->createForm(CharacterType::class, $character);

        //
        $characterForm->handleRequest($request);
        if ($characterForm->isSubmitted() && $characterForm->isValid()) {
            // hydratation des champs
            $slug = $slugger->slug($character->getName());
            $character->setSlug($slug)
                      ->setGold(0)
                      ->setUser($this->getUser())
                      ->setPv($character->getPvMax())
                      ->setPm($character->getPmMax())
                      ->setPc($character->getPcMax())
                      ->setcreatedAt(new DateTimeImmutable());
            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();
            $this->insertWeapon($character, $entityManager);


            $this->addFlash('success', 'Bonjour '.$character->getName().'! Soyez le bienvenue sur Guintuaris.');
            return $this->redirectToRoute('character_view', ["id" => $character->getId(), "slug" => $character->getSlug()]);
        }
        return $this->render('character/character/create.html.twig', [
            "characterForm" => $characterForm->createView()
        ]);
    }
     /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table armor_piece_character
     * le locationNumber est un nombre compris entre 1 et 7 (donnée par la boucle) il represente en meme temps la localisation de l'armure.
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     */
    private function insertPiece(Character $character, ArmorLocationRepository $armorLocationRepository, EntityManagerInterface $entityManager)
    {
        $locations = $armorLocationRepository->findAll();
        foreach ($locations as $location) {
            $armorPieceCharacter = new ArmorPieceCharacter();
            $armorPieceCharacter->setCharact($character)
            ->setId($location->getId());
            
            $entityManager->persist($armorPieceCharacter);
            $entityManager->flush();
        }
    }

    /**
     * cette fonction permet d'inserrer une nouvelle ligne dans la table arme_personnage
     * ces ligne sont mis dans une fonction parce que je trouve sa plus lisible
     *
     */
    private function insertWeapon(Character $character, EntityManagerInterface $entityManager)
    {
        for ($i=1; $i <=3; $i++) { 
            $weaponCharacter = new WeaponCharacter();
            $weaponCharacter->setId($i)
            ->setCharact($character);
            $entityManager->persist($weaponCharacter);
            $entityManager->flush();
        }
    }
}
