<?php

namespace App\Controller\Admin;

use App\Repository\ArmorPieceCharacterRepository;
use App\Repository\CharacterRepository;
use App\Repository\SkillRepository;
use App\Repository\WeaponCharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    #[Route('/administration/personnage/list', name: 'admin_character_list')]
    public function index(CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findAllName();

        return $this->render('admin/character/list.html.twig', [
            "characters" => $characters
        ]);
    }

    #[Route("/administration/personnage/{characterSlug}/{characterId}", name: "admin_character_view")]
    public function fichePerso(
        string $characterSlug,
        int $characterId,
        SkillRepository $skillRepository,
        CharacterRepository $characterRepository,
        ArmorPieceCharacterRepository $armorPieceCharacterRepository,
        WeaponCharacterRepository $weaponCharacterRepository): Response
    {
        $character = $characterRepository->findOneBy(["id" => $characterId, "slug" => $characterSlug]);
        //requete pour les competence
        if (!$character) {
            return $this->redirectToRoute("character_list");
        }
        //$teammates = $doctrine->getRepository(Character::class)->findNameByTeam($teamId, $this->getUser()->getId(), $character->getId());
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $armor = $armorPieceCharacterRepository->findBy(["charact" => $character->getId()]);
        $weapons = $weaponCharacterRepository->findBy(["charact" => $character->getId()]);

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
