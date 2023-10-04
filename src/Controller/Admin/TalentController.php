<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Talent;
use App\Form\TalentFormType;
use App\Repository\TalentRepository;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/administration/talent', name: 'admin_')]
class TalentController extends AbstractController
{
    #[Route('/ajouter', name: 'add_talent')]
    public function addTalent(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger): Response
    {
        $newTalent = new Talent();

        $talentForm = $this->createForm(TalentFormType::class, $newTalent);
        $talentForm->handleRequest($request);
        if ($talentForm->isSubmitted() && $talentForm->isValid()) {
            $slug = $slugger->slug($newTalent->getName());
            $newTalent->setSlug($slug);
            $entityManager->persist($newTalent);
            $entityManager->flush();
            
            $this->addFlash("success", "Le talent a été ajoutée avec succès.");
            return $this->redirectToRoute("admin_talent_list");
        }
        return $this->render('admin/talent/form.html.twig', [
            "talentForm" => $talentForm->createView()

        ]);
    }

    #[Route('/liste', name: 'talent_list')]
    public function talentList(TalentRepository $talentRepository): Response
    {
        $talents = $talentRepository->findBy([], ["id" => "ASC"]);
        return $this->render('admin/talent/list.html.twig', [
            'talents' => $talents,
        ]);
    }

    #[Route('/modifier/{id}', name: 'update_talent')]
    public function updateTalent(int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        TalentRepository $talentRepository): Response
    {
        $talent = $talentRepository->find($id);
        $talentForm = $this->createForm(TalentFormType::class, $talent);
        $talentForm->handleRequest($request);
        if ($talentForm->isSubmitted() && $talentForm->isValid()) {
            $slug = $slugger->slug($talent->getName());
            $talent->setSlug($slug);
            $entityManager->persist($talent);
            $entityManager->flush();
            
            $this->addFlash("success", "Le talent a été modifié avec succès.");
            return $this->redirectToRoute("admin_talent_list");
        }
        return $this->render('admin/talent/form.html.twig', [
            "talentForm" => $talentForm->createView()
        ]);
    }

}
