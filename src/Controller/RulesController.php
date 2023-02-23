<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Race;
use App\Entity\Skill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RulesController extends AbstractController
{
    #[Route('/race/{slug}', name: 'race')]
    public function race(string $slug, ManagerRegistry $doctrine): Response
    {
        $race = $doctrine->getRepository(Race::class)->findOneBy(["slug" => $slug]);
        return $this->render('rules/race.html.twig', [
            'race' => $race
        ]);
    }

    #[Route('/classe/{slug}', name: 'class')]
    public function classe(string $slug, ManagerRegistry $doctrine): Response
    {
        $class = $doctrine->getRepository(Classes::class)->findOneBy(["slug" => $slug]);

        $skills = $doctrine->getRepository(Skill::class)->findByClass( $class->getId());
        return $this->render('rules/classe.html.twig', [
            'classe' => $class,
            'skills' => $skills
        ]);
    }

    #[Route('/regles', name: 'teaser_rules')]
    public function rules(): Response
    {
        return $this->render('rules/rules.html.twig');
    }


}
