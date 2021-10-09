<?php

namespace App\Controller;

use App\Entity\PieceArmure;
use App\Form\PieceArmureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PieceArmureController extends AbstractController
{
    /**
     * @Route("/admin/ajout_piece", name="add_piece")
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
        return $this->render('piece_armure/addPiece.html.twig', [
            "pieceForm" => $pieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }
}
