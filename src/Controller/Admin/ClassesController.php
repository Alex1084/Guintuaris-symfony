<?php

namespace App\Controller\Admin;

use App\Entity\Classes;
use App\Form\ClassesFormType;
use App\Repository\ClassesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/administration/classe', name: 'admin_')]
class ClassesController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/ajouter", name:"add_class")]
    public function addClass(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger): Response
    {
        $class = new Classes();
        $classForm = $this->createForm(ClassesFormType::class, $class);

        $classForm->handleRequest($request);
        if ($classForm->isSubmitted() && $classForm->isValid()) {
            $slug = $slugger->slug($class->getName());
            $class->setSlug($slug);
            $entityManager->persist($class);
            $entityManager->flush();
            $this->addFlash("success", "La classe ".$class->getName()." a été créé avec sucée, les joueurs peuvent désormais créer des personnages avec cette classe.");
            return $this->redirectToRoute("admin_class_list");
        }
        return $this->render('admin/class/form.html.twig', [
            "classForm" => $classForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/liste", name:"class_list")]
    public function classList(ClassesRepository $classRepository): Response
    {
        $classs = $classRepository->classList();
        return $this->render('admin/class/list.html.twig', [
            'classs' => $classs
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier/{slug}", name:"update_class")]
    public function updateClass(
        string $slug,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        ClassesRepository $classesRepository): Response
    {
        $class = $classesRepository->findOneBy(["slug" => $slug]);
        $classForm = $this->createForm(ClassesFormType::class, $class);
        $oldName = $class->getName();
        $classForm->handleRequest($request);
        if ($classForm->isSubmitted() && $classForm->isValid()) {
            if ($oldName !== $class->getName()) {
                
                $slug = $slugger->slug($class->getName());
                $class->setSlug($slug);
                $this->addFlash("success", "La classe ".$oldName." a été renommé en ".$class->getName().".");
        }
            $entityManager->persist($class);
            $entityManager->flush();
            $this->addFlash("success", "la classe a été mis a jour avec succés");
            return $this->redirectToRoute("admin_class_list");
        }
        return $this->render('admin/class/form.html.twig', [
            "classForm" => $classForm->createView()
        ]);
    }
}
