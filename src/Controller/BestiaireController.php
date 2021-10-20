<?php

namespace App\Controller;

use App\Entity\Bestiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestiaireController extends AbstractController
{
    /**
     * @Route("/bestiaire", name="bestiaire")
     */
    public function index(): Response
    {
        $beteForm = $this->createFormBuilder()
                        ->add('bete', EntityType::class,[
                            'class' => Bestiaire::class,
                            'choice_label' => 'nom',
                        ])
                        ->getForm();
        return $this->render('bestiaire/mjboard.html.twig', [
            'beteForm' => $beteForm->createView(),
        ]);
    }
}
