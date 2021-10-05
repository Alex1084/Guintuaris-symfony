<?php

namespace App\Controller;

use App\Entity\Race;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{
    /**
     * @Route("/race/{id}", name="race")
     */
    public function index($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Race::class);
        $race = $repo->find($id);
        return $this->render('race/index.html.twig', [
            'race' => $race
        ]);
    }
}
