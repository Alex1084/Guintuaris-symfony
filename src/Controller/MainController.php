<?php

namespace App\Controller;

use App\Repository\ClassesRepository;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * affiche la page d'acceuil du site
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
    public function init(
        ClassesRepository $classesRepository,
        RaceRepository $raceRepository
    ): Response
    {
        $classes = $classesRepository->classList();
        $races = $raceRepository->raceList();

        return $this->json([
            "classes" => $classes,
            "races" => $races
        ]);
        
    }
    /**
     * cette page afiche juste l'easter egg cacher dans le site
     */
    #[Route('/easter', name: 'main_egg')]
    public function easterEgg(): Response
    {
        return $this->render('main/easter.html.twig');
    }
}
