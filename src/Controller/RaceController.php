<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Race;
use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{
    /**
     * @Route("/race/{id}", name="race")
     */
    public function race($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Race::class);
        $race = $repo->find($id);
        return $this->render('race/race.html.twig', [
            'race' => $race
        ]);
    }
     /**
     * @Route("/classe/{id}", name="classe")
     */
    public function classe($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Classes::class);
        $class = $repo->find($id);

        $repo = $this->getDoctrine()->getRepository(Skill::class);
        $skills = $repo->findBy(array("class" => $class));
        return $this->render('race/classe.html.twig', [
            'classe' => $class,
            'skills' => $skills
        ]);
    }
}
