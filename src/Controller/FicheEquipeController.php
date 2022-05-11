<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\WeaponCharacter;
use App\Repository\CharacterRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe", name="equipe_")
 */
class FicheEquipeController extends AbstractController
{
    /**
     * cette page affiche la list des membre apartenent à l'equipe qui se trouve en parametre
     * l'objectif serais qu'un joueur qui n'a pas de personnage dans une equipe ne puisse pas y acceder par l'url
     * 
     * @Route("/list/{teamId}", name="list")
     *
     */
    public function teamMembersList(int $teamId, CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findNameByTeam($teamId);
        return $this->render('fiche_equipe/listEquipe.html.twig', [
            "characters" => $characters,
            "teamId" => $teamId,
        ]);
    }
    /**
     * cette page affiche une fiche de personnage qui ne peut pas être editer
     * le membre y on seulement un accee afin de pouvoir voir les fiche des membre de leur equipe
     * 
     * @Route("/{teamId}/fiche/{characterId}", name="fiche_view")
     *
     */
    public function fichePerso(int $teamId, int $characterId, SkillRepository $skillRepository): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->find($characterId);
        //requete pour les competence
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
        $weapons = $this->getDoctrine()->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);

        // creation d'un formulaire en readonly pour voir le statut

        return $this->render('fiche_equipe/ficheEquipier.html.twig', [
            'teamId' => $teamId,
            'character' => $character,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons
        ]);
    }
}
