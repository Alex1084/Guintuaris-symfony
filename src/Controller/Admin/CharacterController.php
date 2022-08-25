<?php

namespace App\Controller\Admin;

use App\Entity\Character;
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
}
