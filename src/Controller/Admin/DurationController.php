<?php

namespace App\Controller\Admin;

use App\Entity\DurationType;
use App\Form\DurationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/duration', name: 'admin_')]
class DurationController extends AbstractController
{
    #[Route("/ajouter", name:"add_duration")]
    public function addClass(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newDuration = new DurationType();

        $durationForm = $this->createForm(DurationFormType::class, $newDuration);
        $durationForm->handleRequest($request);
        if ($durationForm->isSubmitted() && $durationForm->isValid()) {
            $entityManager->persist($newDuration);
            $entityManager->flush();

            $this->addFlash("success", "la ressource a été ajouté avec succés");
            return $this->redirectToRoute("admin_duration_list");
        }
        return $this->render('admin/duration/form.html.twig', [
            "durationForm" => $durationForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/liste", name:"duration_list")]
    public function classList(ManagerRegistry $doctrine): Response
    {
        $durations = $doctrine->getRepository(DurationType::class)->findAll();
        return $this->render('admin/duration/list.html.twig', [
            "durations" => $durations
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier/{id}", name:"update_duration")]
    public function updateClass(int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $duration = $doctrine->getRepository(DurationType::class)->find($id);
        $durationForm = $this->createForm(DurationFormType::class, $duration);

        $durationForm->handleRequest($request);
        if ($durationForm->isSubmitted() && $durationForm->isValid()) {
            $entityManager->persist($duration);
            $entityManager->flush();
            $this->addFlash("success", "la ressource a été modifié avec succés");
            return $this->redirectToRoute("admin_duration_list");
        }
        return $this->render('admin/duration/form.html.twig', [
            "durationForm" => $durationForm->createView()
        ]);
    }
}
