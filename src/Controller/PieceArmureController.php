<?php

namespace App\Controller;

use App\Entity\PieceArmure;
use App\Form\PieceArmureType;
use App\Repository\PieceArmureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PieceArmureController extends AbstractController
{
    

    /**
     * @Route("/viewarmure", name="view_armure")
     */
    public function viewArmure(PieceArmureRepository $armurerepo){
        $vide = $armurerepo->getArmurebyTypeEmplacement('12', 1) ;
        dump($vide);

        return $this->render('piece_armure/viewArmure.html.twig', [
            "vide" => $vide
        ]);
    }
}
