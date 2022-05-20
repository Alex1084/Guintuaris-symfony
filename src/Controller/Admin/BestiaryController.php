<?php

namespace App\Controller\Admin;

use App\Entity\Bestiary;
use App\Form\BestiaryFormType;
use App\Repository\BestiaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class BestiaryController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/ajouter-creature', name: 'add_bestiary')]
    public function addBestiary(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bestiary = new Bestiary();
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted()) {
            $bestiary->setPv($bestiary->getPvMax())
                ->setPc($bestiary->getPcMax())
                ->setPm($bestiary->getPmMax());
            $entityManager->persist($bestiary);
            $entityManager->flush();

            return $this->redirectToRoute("admin_bestiary_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/creature-list', name: 'bestiary_list')]
    public function bestiaryList(BestiaryRepository $bestiaryRepository): Response
    {
        $creatures = $bestiaryRepository->bestiaryList();
        return $this->render('admin/bestiary/list.html.twig', [
            'creatures' => $creatures
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/modifier-creature/{bestiaryId}', name: 'update_bestiary')]
    public function updateBestiary(int $bestiaryId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $bestiary = $doctrine->getRepository(Bestiary::class)->find($bestiaryId);
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted()) {
            $bestiary->setPv($bestiary->getPvMax())
                 ->setPc($bestiary->getPcMax())
                 ->setPm($bestiary->getPmMax());
            $entityManager->persist($bestiary);
            $entityManager->flush();
            return $this->redirectToRoute("admin_bestiary_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }

    /**
     * 
     */
    #[Route('/supprimer-creature/{bestiaryId}', name: 'delete_bestiary')]
    public function deleteBestiary(int $bestiaryId, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $bestiary = $doctrine->getRepository(Bestiary::class)->find($bestiaryId);
            $entityManager->remove($bestiary);
            $entityManager->flush();
            return $this->json("delete Succes");
    }
}
