<?php

namespace App\Controller\Admin;

use Cocur\Slugify\Slugify;
use App\Entity\Race;
use App\Form\RaceFormType;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class RaceController extends AbstractController
{
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/ajouter-race", name:"add_race")]
    public function addRace(Request $request, EntityManagerInterface $entityManager): Response
    {
        $race = new Race();
        $raceForm = $this->createForm(RaceFormType::class, $race);

        $raceForm->handleRequest($request);
        if ($raceForm->isSubmitted()) {
            $slugify = new Slugify();
            $slug = $slugify->slugify($race->getName());
            $race->setSlug($slug);
            $entityManager->persist($race);
            $entityManager->flush();
            $this->addFlash("success", "la classe ".$race->getName()." a été crée avec succée, les joueur peuvent peuvent désormer céer des personnage avec cette race");
            return $this->redirectToRoute("admin_race_list");
        }
        return $this->render('admin/race/form.html.twig', [
            "raceForm" => $raceForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/race-list", name:"race_list")]
    public function raceList(RaceRepository $raceRepository): Response
    {
        $races = $raceRepository->raceList();
        return $this->render('admin/race/list.html.twig', [
            'races' => $races
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier-race/{slug}", name:"update_race")]
    public function updateRace(string $slug, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $race = $doctrine->getRepository(Race::class)->findOneBy(["slug" => $slug]);
        $raceForm = $this->createForm(RaceFormType::class, $race);
        $oldName = $race->getName();
        $raceForm->handleRequest($request);
        if ($raceForm->isSubmitted()) {
            if ($oldName !== $race->getName()) {
                $slugify = new Slugify();
                $slug = $slugify->slugify($race->getName());
                $race->setSlug($slug);
                $this->addFlash("success", "la race ".$oldName." à été renommé en ".$race->getName());
            }
            $entityManager->persist($race);
            $entityManager->flush();
            $this->addFlash("success", "la race a été mis a jour avec succés");
            return $this->redirectToRoute("admin_race_list");
        }
        return $this->render('admin/race/form.html.twig', [
            "raceForm" => $raceForm->createView()
        ]);
    }
}
