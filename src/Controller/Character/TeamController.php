<?php

namespace App\Controller\Character;

use App\Repository\ArmorPieceCharacterRepository;
use App\Repository\CharacterRepository;
use App\Repository\SkillRepository;
use App\Repository\StatisticRepository;
use App\Repository\TalentRepository;
use App\Repository\TeamRepository;
use App\Repository\WeaponCharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe', name: 'team_')]
class TeamController extends AbstractController
{
    /**
     * cette page affiche la list des membre apartenent à l'equipe qui se trouve en parametre
     * l'objectif serais qu'un joueur qui n'a pas de personnage dans une equipe ne puisse pas y acceder par l'url
     */
    #[Route('/list/{teamSlug}/{teamId}', name: 'list')]
    public function teamMembersList(
        string $teamSlug,
        int $teamId,
        TeamRepository $teamRepository,
        CharacterRepository $characterRepository): Response
    {
        $team = $teamRepository->findOneBy(["id" => $teamId, "slug" => $teamSlug]);
        $charactersUser = $characterRepository->findBy(["user" => $this->getUser(), "team" => $team], ["name" => "ASC"]);
        if ($charactersUser === [] && $team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $characters = $characterRepository->findNameByTeam($teamId, $this->getUser()->getId());
        return $this->render('character/team/teammateList.html.twig', [
            "characters" => $characters,
            "team" => $team,
            "charactersUser" => $charactersUser
        ]);
    }

    #[Route('/{teamSlug}/{teamId}/{characterSlug}/{characterId}', name: 'sheet_view')]
    /**
     * cette page affiche une fiche de personnage qui ne peut pas être editer
     * le membre y on seulement un accee afin de pouvoir voir les fiche des membre de leur equipe
     */
    public function fichePerso(
        string $teamSlug,
        int $teamId,string $characterSlug,
        int $characterId,
        SkillRepository $skillRepository,
        TeamRepository $teamRepository,
        CharacterRepository $characterRepository,
        StatisticRepository $statisticRepository,
        TalentRepository $talentRepository,
        ArmorPieceCharacterRepository $armorPieceCharacterRepository,
        WeaponCharacterRepository $weaponCharacterRepository
        ): Response
    {
        $team = $teamRepository->findOneBy(["id" => $teamId,"slug"=>$teamSlug]);
        $charactersUser = $characterRepository->findBy(["user" => $this->getUser(), "team" => $team], ["name" => "ASC"]);
        if ($charactersUser == [] && $team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $character = $characterRepository->findOneBy(["id" => $characterId, "slug" => $characterSlug, "team" => $team]);
        //requete pour les competence
        if (!$character) {
            return $this->redirectToRoute("character_list");
        }
        $statistics = $statisticRepository->findAllNames();
        $talents = $talentRepository->findAllNames();
        $teammates = $characterRepository->findNameByTeam($teamId, $this->getUser()->getId(), $character->getId());
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $armorPieceCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "ASC"]);
        $weapons = $weaponCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "ASC"]);

        // creation d'un formulaire en readonly pour voir le statut

        return $this->render('character/team/teammateSheet.html.twig', [
            'team' => $team,
            'character' => $character,
            'charactersUser' => $charactersUser,
            "teammates" => $teammates,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons,
            'statistics' => $statistics,
            'talents' => $talents,
        ]);
    }
}
