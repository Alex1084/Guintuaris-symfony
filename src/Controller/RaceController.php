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
    public function race(int $id): Response
    {
        $race = $this->getDoctrine()->getRepository(Race::class)->find($id);
        return $this->render('race/race.html.twig', [
            'race' => $race
        ]);
    }
     /**
     * @Route("/classe/{id}", name="class")
     */
    public function classe(int $id): Response
    {
        $class = $this->getDoctrine()->getRepository(Classes::class)->find($id);

        $skills = $this->getDoctrine()->getRepository(Skill::class)->findBy(array("class" => $class));
        return $this->render('race/classe.html.twig', [
            'classe' => $class,
            'skills' => $skills
        ]);
    }
}
