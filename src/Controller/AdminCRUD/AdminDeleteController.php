<?php

namespace App\Controller\AdminCRUD;

use App\Entity\ArmorLocation;
use App\Entity\ArmorType;
use App\Entity\BestiaryType;
use App\Entity\Character;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
#[Route("/admin", name:"admin_")]
class AdminDeleteController extends AbstractController
{

    /**
     * Undocumented function
     */
    #[Route("/retire-membre/{characterId}", name:"delete_team_member")]
    public function deleteTeamMember(int $characterId, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $character = $doctrine->getRepository(Character::class)->find($characterId);
        // if ($this->getUser()->getRoles() === "ROLE_ADMIN") {
            $character->setTeam(null);
            $entityManager->persist($character);
            $entityManager->flush();
            return $this->json("delete Succes");
        // } else {
            return $this->json("access denied", 403);
        // }
    }

    /**
     * Undocumented function
     */
    #[Route("/supprimer-equipe/{id}", name:"delete_team")]
    public function deleteTeam(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $team = $doctrine->getRepository(Team::class)->find($id);
            $entityManager->remove($team);
            $entityManager->flush();
            return $this->json("delete Succes");
    }
}
