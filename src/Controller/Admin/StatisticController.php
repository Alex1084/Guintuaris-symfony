<?php

namespace App\Controller\Admin;

use App\Entity\Statistic;
use App\Form\StatisticFormType;
use App\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/statistiques', name: 'admin_')]
class StatisticController extends AbstractController
{
    #[Route("/ajouter", name:"add_statistic")]
    public function addClass(
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $newStatistic = new Statistic();

        $statisticForm = $this->createForm(StatisticFormType::class, $newStatistic);
        $statisticForm->handleRequest($request);
        if ($statisticForm->isSubmitted() && $statisticForm->isValid()) {
            $entityManager->persist($newStatistic);
            $entityManager->flush();

            $this->addFlash("success", "La ressource a été ajoutée avec succès.");
            return $this->redirectToRoute("admin_statistic_list");
        }
        return $this->render('admin/statistic/form.html.twig', [
            "statisticForm" => $statisticForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/liste", name:"statistic_list")]
    public function classList(StatisticRepository $statisticRepository): Response
    {
        $statistics = $statisticRepository->findBy([], ["id" => "ASC"]);
        return $this->render('admin/statistic/list.html.twig', [
            "statistics" => $statistics
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier/{id}", name:"update_statistic")]
    public function updateClass(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        StatisticRepository $statisticRepository): Response
    {
        $statistic = $statisticRepository->find($id);
        $statisticForm = $this->createForm(StatisticFormType::class, $statistic);

        $statisticForm->handleRequest($request);
        if ($statisticForm->isSubmitted() && $statisticForm->isValid()) {
            $entityManager->persist($statistic);
            $entityManager->flush();
            $this->addFlash("success", "La ressource a été modifiée avec succès.");
            return $this->redirectToRoute("admin_statistic_list");
        }
        return $this->render('admin/statistic/form.html.twig', [
            "statisticForm" => $statisticForm->createView()
        ]);
    }
}
