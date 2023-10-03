<?php

namespace App\Controller\Admin;

use App\Entity\DurationType;
use App\Form\DurationFormType;
use App\Repository\DurationTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/duration', name: 'admin_')]
class DurationController extends AbstractController
{
    #[Route("/ajouter", name:"add_duration")]
    public function addClass(
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $newDuration = new DurationType();

        $durationForm = $this->createForm(DurationFormType::class, $newDuration);
        $durationForm->handleRequest($request);
        if ($durationForm->isSubmitted() && $durationForm->isValid()) {
            $entityManager->persist($newDuration);
            $entityManager->flush();

            $this->addFlash("success", "La ressource a été ajoutée avec succès.");
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
    public function classList(DurationTypeRepository $durationTypeRepository): Response
    {
        $durations = $durationTypeRepository->findBy([], ["id" => "ASC"]);
        return $this->render('admin/duration/list.html.twig', [
            "durations" => $durations
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier/{id}", name:"update_duration")]
    public function updateClass(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        DurationTypeRepository $durationTypeRepository): Response
    {
        $duration = $durationTypeRepository->find($id);
        $durationForm = $this->createForm(DurationFormType::class, $duration);

        $durationForm->handleRequest($request);
        if ($durationForm->isSubmitted() && $durationForm->isValid()) {
            $entityManager->persist($duration);
            $entityManager->flush();
            $this->addFlash("success", "La ressource a été modifiée avec succès.");
            return $this->redirectToRoute("admin_duration_list");
        }
        return $this->render('admin/duration/form.html.twig', [
            "durationForm" => $durationForm->createView()
        ]);
    }
}
