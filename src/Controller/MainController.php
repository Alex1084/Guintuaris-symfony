<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * affiche la page d'acceuil du site
     * 
     * @Route("/", name="main_home")
     *
     * @return Response
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }
    /**
     * cette page afiche juste l'easter egg cacher dans le site
     * 
     * @Route("/easter", name="main_egg")
     *
     * @return Response
     */
    public function easterEgg(): Response
    {
        return $this->render('main/easter.html.twig');
    }
}
