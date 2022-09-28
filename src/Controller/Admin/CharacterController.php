<?php

namespace App\Controller\Admin;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\Team;
use App\Entity\WeaponCharacter;
use App\Repository\SkillRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/administration/personnage/list', name: 'admin_character_list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $characters = $doctrine->getRepository(Character::class)->findAllName();

        return $this->render('admin/character/list.html.twig', [
            "characters" => $characters
        ]);
    }

    #[Route("/administration/personnage/{characterSlug}/{characterId}", name: "admin_character_view")]
    public function fichePerso(string $characterSlug,  int $characterId, SkillRepository $skillRepository, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["id" => $characterId, "slug" => $characterSlug]);
        //requete pour les competence
        if (!$character) {
            return $this->redirectToRoute("character_list");
        }
        //$teammates = $doctrine->getRepository(Character::class)->findNameByTeam($teamId, $this->getUser()->getId(), $character->getId());
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $doctrine->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
        $weapons = $doctrine->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);

        return $this->render('character/team/teammateSheet.html.twig', [
            //'team' => $team,
            'character' => $character,
            //'charactersUser' => $charactersUser,
            //"teammates" => $teammates,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons
        ]);
    }
}
