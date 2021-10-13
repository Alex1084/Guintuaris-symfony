<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/admin", name="admin_")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', [
        ]);
    }


    /**
     * @Route("/add_competence", name="add_competence")
     */
    public function competence(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competence = new Competence();
        $competenceForm = $this->createForm(CompetenceType::class, $competence);
        
        $competenceForm->handleRequest($request);
        if($competenceForm->isSubmitted()){

            $entityManager->persist($competence);
            $entityManager->flush();
        }
        return $this->render('admin/addcompetence.html.twig', [
            "competenceForm" => $competenceForm->createView()
        ]);
    }
}
