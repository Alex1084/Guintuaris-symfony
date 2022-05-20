<?php

namespace App\Controller\Admin;

use App\Entity\Classes;
use App\Form\ClassesFormType;
use App\Repository\ClassesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ClassesController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/ajouter-classe", name:"add_class")]
    public function addClass(Request $request, EntityManagerInterface $entityManager): Response
    {
        $class = new Classes();
        $classForm = $this->createForm(ClassesFormType::class, $class);

        $classForm->handleRequest($request);
        if ($classForm->isSubmitted()) {

            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute("admin_class_list");
        }
        return $this->render('admin/class/form.html.twig', [
            "classForm" => $classForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/classe-list", name:"class_list")]
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
    #[Route("/modifier-classe/{classId}", name:"update_class")]
    public function updateClass(int $classId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $class = $doctrine->getRepository(Classes::class)->find($classId);
        $classForm = $this->createForm(ClassesFormType::class, $class);

        $classForm->handleRequest($request);
        if ($classForm->isSubmitted()) {

            $entityManager->persist($class);
            $entityManager->flush();
            return $this->redirectToRoute("admin_class_list");
        }
        return $this->render('admin/class/form.html.twig', [
            "classForm" => $classForm->createView()
        ]);
    }
}
