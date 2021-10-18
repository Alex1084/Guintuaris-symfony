<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\PieceArmurePersonnage;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe", name="equipe_")
 */
class FicheEquipeController extends AbstractController
{
    /**
     * @Route("/equipe/{idEquipe}/fiche/{idPersonnage}", name="fiche_view")
     */
    public function fichePerso($idPersonnage, CompetenceRepository $compRepo): Response
    {
        //dd($request);
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($idPersonnage);
        $competences = $compRepo->findByLevel($personnage->getNiveau(), $personnage->getClasse()->getId());
        $repo = $this->getDoctrine()->getRepository(PieceArmurePersonnage::class);
        $armure = $repo->findBy(array("personnage" =>$personnage->getId()));
        //~~~~~~~~~~~~~~~~~~~~~~~formulaire pour les trois bar~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 
        $statForm = $this->get('form.factory')->createNamedBuilder('stat',FormType::class, $personnage)
                    ->add('pv', IntegerType::class)
                    ->add('pm', IntegerType::class)
                    ->add('pc', IntegerType::class)
                    ->getForm();
         
        //dd($inventaireForm);
        return $this->render('fiche_equipe/ficheEquipier.html.twig',[
            'personnage' => $personnage,
            'statForm' => $statForm->createView(),
            'competences' => $competences,
            'armure' => $armure,
        ]);
    }
}
