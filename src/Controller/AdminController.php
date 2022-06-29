<?php

namespace App\Controller;

use App\Entity\ArmorPiece;
use App\Entity\Character;
use App\Entity\Team;
use App\Form\ArmorPieceType;
use App\Repository\ArmorPieceRepository;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{

    /**
     * affiche le lien des pour acceder au fonctionaliter administrateur
     *
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', []);
    }
}
