<?php

namespace App\Controller\Character;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\Statistic;
use App\Entity\Talent;
use App\Entity\Team;
use App\Entity\WeaponCharacter;
use App\Repository\CharacterRepository;
use App\Repository\SkillRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe', name: 'team_')]
class TeamController extends AbstractController
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
    public function teamMembersList(string $teamSlug, int $teamId, ManagerRegistry $doctrine): Response
    {
        $team = $doctrine->getRepository(Team::class)->findOneBy(["id" => $teamId, "slug" => $teamSlug]);
        $charactersUser = $doctrine->getRepository(Character::class)->findBy(["user" => $this->getUser(), "team" => $team], ["name" => "ASC"]);
        if ($charactersUser === [] && $team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $characters = $doctrine->getRepository(Character::class)->findNameByTeam($teamId, $this->getUser()->getId());
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
     *
     * @param integer $teamId
     * @param integer $characterId
     * @param SkillRepository $skillRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function fichePerso(string $teamSlug, int $teamId,string $characterSlug,  int $characterId, SkillRepository $skillRepository, ManagerRegistry $doctrine): Response
    {
        $team = $doctrine->getRepository(Team::class)->findOneBy(["id" => $teamId,"slug"=>$teamSlug]);
        $charactersUser = $doctrine->getRepository(Character::class)->findBy(["user" => $this->getUser(), "team" => $team], ["name" => "ASC"]);
        if ($charactersUser == [] && $team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $character = $doctrine->getRepository(Character::class)->findOneBy(["id" => $characterId, "slug" => $characterSlug, "team" => $team]);
        //requete pour les competence
        if (!$character) {
            return $this->redirectToRoute("character_list");
        }
        $statistics = $doctrine->getRepository(Statistic::class)->findAllNames();
        $talents = $doctrine->getRepository(Talent::class)->findAllNames();
        $teammates = $doctrine->getRepository(Character::class)->findNameByTeam($teamId, $this->getUser()->getId(), $character->getId());
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $doctrine->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()], ["id" => "ASC"]);
        $weapons = $doctrine->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()], ["id" => "ASC"]);

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
