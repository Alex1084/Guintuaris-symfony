<?php

namespace App\Controller\Admin;

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

            $entityManager->persist($race);
            $entityManager->flush();

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
    #[Route("/modifier-race/{raceId}", name:"update_race")]
    public function updateRace(int $raceId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $race = $doctrine->getRepository(Race::class)->find($raceId);
        $raceForm = $this->createForm(RaceFormType::class, $race);

        $raceForm->handleRequest($request);
        if ($raceForm->isSubmitted()) {

            $entityManager->persist($race);
            $entityManager->flush();
            return $this->redirectToRoute("admin_race_list");
        }
        return $this->render('admin/race/form.html.twig', [
            "raceForm" => $raceForm->createView()
        ]);
    }
}
