<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\PieceArmure;
use App\Form\CompetenceType;
use App\Form\PieceArmureType;
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
    /**
     * @Route("/ajout_piece", name="add_piece")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(PieceArmure::class);
        $piecesTab = $repo->findAll(); 
        $piece = new PieceArmure();
        $pieceForm = $this->createForm(PieceArmureType::class, $piece);
        
        $pieceForm->handleRequest($request);
        if($pieceForm->isSubmitted()){
            $entityManager->persist($piece);
            $entityManager->flush();

            return $this->redirectToRoute('add_piece');
        }
        return $this->render('admin/addPiece.html.twig', [
            "pieceForm" => $pieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }
    /**
     * @Route("/ajout_membre", name="add_membre")
     */
    public function addMembreEquipe(){

        return $this->render('admin/addMembreEquipe.html.twig');
    }
}
