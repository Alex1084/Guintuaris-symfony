<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Race;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * affiche la page d'acceuil du site
     *
     * @return Response
     */
    #[Route('/', name: 'main_home')]
    public function index(): Response
    {
        return $this->render('main/home.html.twig');
    }

    #[Route('/le-bureau', name: 'teaser_office')]
    public function office(): Response
    {
        return $this->render('main/office.html.twig');
    }

    #[Route('/init-nav-bar', name: 'init_nav_bar')]
    public function init(ManagerRegistry $doctrine): Response
    {
        $classes = $doctrine->getRepository(Classes::class)->classList();
        $races = $doctrine->getRepository(Race::class)->raceList();

        return $this->json([
            "classes" => $classes,
            "races" => $races
        ]);
        
    }
    /**
     * cette page afiche juste l'easter egg cacher dans le site
     *
     * @return Response
     */
    #[Route('/easter', name: 'main_egg')]
    public function easterEgg(): Response
    {
        return $this->render('main/easter.html.twig');
    }
}
