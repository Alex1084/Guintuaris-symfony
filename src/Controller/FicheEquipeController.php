<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\WeaponCharacter;
use App\Repository\CharacterRepository;
use App\Repository\SkillRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe', name: 'team_')]
class FicheEquipeController extends AbstractController
{
    /**
     * cette page affiche la list des membre apartenent à l'equipe qui se trouve en parametre
     * l'objectif serais qu'un joueur qui n'a pas de personnage dans une equipe ne puisse pas y acceder par l'url
     *
     * @param integer $teamId
     * @param CharacterRepository $characterRepository
     * @return Response
     */
    #[Route('/list/{teamSlug}/{teamId}', name: 'list')]
    public function teamMembersList(string $teamSlug, int $teamId, CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findNameByTeam($teamId);
        return $this->render('fiche_equipe/listEquipe.html.twig', [
            "characters" => $characters,
            "teamId" => $teamId,
            "teamSlug" => $teamSlug
        ]);
    }

    #[Route('/{teamSlug}/{teamId}/{characterSlug}/{characterId}', name: 'sheet_view')]
    /**
     * cette page affiche une fiche de personnage qui ne peut pas être editer
     * le membre y on seulement un accee afin de pouvoir voir les fiche des membre de leur equipe
     *
     * @param integer $teamId
     * @param integer $characterId
     * @param SkillRepository $skillRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function fichePerso(string $teamSlug, int $teamId,string $characterSlug,  int $characterId, SkillRepository $skillRepository, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["id" => $characterId, "slug" => $characterSlug, "team" => $teamId]);
        //requete pour les competence
        if (!$character) {
            return $this->redirectToRoute("character_list");
        }
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $doctrine->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
        $weapons = $doctrine->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);

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
