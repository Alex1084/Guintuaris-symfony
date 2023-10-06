<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Race;
use App\Entity\Skill;
use App\Repository\ClassesRepository;
use App\Repository\RaceRepository;
use App\Repository\SkillRepository;
use App\Repository\StatisticRepository;
use App\Repository\TalentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RulesController extends AbstractController
{
    #[Route('/race/{slug}', name: 'race')]
    public function race(
        string $slug,
        RaceRepository $raceRepository): Response
    {
        $race = $raceRepository->findOneBy(["slug" => $slug]);
        return $this->render('rules/race.html.twig', [
            'race' => $race
        ]);
    }

    #[Route('/classe/{slug}', name: 'class')]
    public function classe(
        string $slug,
        ClassesRepository $classesRepository,
        SkillRepository $skillRepository): Response
    {
        $class = $classesRepository->findOneBy(["slug" => $slug]);

        $skills = $skillRepository->findByClass( $class->getId());
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
    #[Route('/regles/repos', name: 'rules_rest')]
    public function restRule(): Response
    {
        return $this->render('rules/rest.html.twig');
    }
    #[Route('/regles/statistiques', name: 'rules_statistic')]
    public function statisticRule(StatisticRepository $statisticRepository): Response
    {
        $statistics = $statisticRepository->findAll();
        return $this->render('rules/statistic.html.twig', [
            "statistics" => $statistics
        ]);
    }
    #[Route('/regles/talents', name: 'rules_talents')]
    public function talentsRule(TalentRepository $talentRepository): Response
    {
        $talents = $talentRepository->findAll();
        return $this->render('rules/talents.html.twig', [
            "talents" => $talents
        ]);
    }
    #[Route('/regles/experience', name: 'rules_experiences')]
    public function experiencesRule(): Response
    {
        return $this->render('rules/experience.html.twig', [
        ]);
    }
    #[Route('/regles/combats', name: 'rules_fight')]
    public function fightRule(): Response
    {
        return $this->render('rules/fight.html.twig', [
        ]);
    }

    #[Route('/regles/jet-contre-la-mort', name: 'rules_death')]
    public function deathRule(): Response
    {
        return $this->render('rules/death.html.twig', [
        ]);
    }
    #[Route('/regles/blessure-grave', name: 'rules_injury')]
    public function injuryRule(): Response
    {
        return $this->render('rules/injury.html.twig', [
        ]);
    }


}
