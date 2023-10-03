<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration', name: 'admin_')]
class AdminController extends AbstractController
{

    /**
     * affiche le lien des pour acceder au fonctionaliter administrateur
     */
    #[Route('/', name: 'home')]
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', []);
    }
}
