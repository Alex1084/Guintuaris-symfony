<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\PieceArmurePersonnage;
use App\Form\PersonnageType;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /*
     * @Route("/personnage", name="personnage_")
     */
class FichePersonnageController extends AbstractController
{
    /**
     * @Route("/{id}", name="view")
     */
     public function fichePerso($id, Request $request, EntityManagerInterface $entityManager, CompetenceRepository $compRepo): Response
    {
        //dd($request);
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        dump($personnage);
        //$competences = $compRepo->findByLevel($personnage->getNiveau(), $personnage->getClasse()->getId());
        $repo = $this->getDoctrine()->getRepository(PieceArmurePersonnage::class);
        //$armure = $repo->findBy(array("personnage" =>$personnage->getId()));
        //~~~~~~~~~~~~~~~~~~~~~~~formulaire pour les trois bar~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 
        $statForm = $this->get('form.factory')->createNamedBuilder('stat',FormType::class, $personnage)
                    ->add('pv', IntegerType::class)
                    ->add('pm', IntegerType::class)
                    ->add('pc', IntegerType::class)
                    ->getForm();
        //~~~~~~~~~~~~~~~~~~~~~~formulaire pour l'inventaire et les PO~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $inventaireForm = $this->get('form.factory')->createNamedBuilder('inventaire',FormType::class, $personnage)
                        ->add('inventaire', TextareaType::class)
                        ->add('po', IntegerType::class)
                        ->getForm();
        if($request->getMethod() === 'POST'){
            $statForm->handleRequest($request);
            $inventaireForm->handleRequest($request);
            if($request->request->has('stat')){
                //dd($request);
                $entityManager->persist($personnage);
                $entityManager->flush();
                //
            }
            if($request->request->has('inventaire')){
                $entityManager->persist($personnage);
                $entityManager->flush();
                //
            }
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        } 
         
        //dd($inventaireForm);
        return $this->render('personnage/fichePersonnage.html.twig',[
            'personnage' => $personnage,
            'statForm' => $statForm->createView(),
            'inventaireForm' => $inventaireForm->createView(),
            //'competences' => $competences,
            //'armure' => $armure,
        ]);
    }
}
