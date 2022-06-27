<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Race;
use App\Entity\Skill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{
    #[Route('/race/{id}', name: 'race')]
    public function race(int $id, ManagerRegistry $doctrine): Response
    {
        $race = $doctrine->getRepository(Race::class)->find($id);
        return $this->render('race/race.html.twig', [
            'race' => $race
        ]);
    }

    #[Route('/classe/{id}', name: 'class')]
    public function classe(int $id, ManagerRegistry $doctrine): Response
    {
        $class = $doctrine->getRepository(Classes::class)->find($id);

        $skills = $doctrine->getRepository(Skill::class)->findBy(array("class" => $class));
        return $this->render('race/classe.html.twig', [
            'classe' => $class,
            'skills' => $skills
        ]);
    }
}
