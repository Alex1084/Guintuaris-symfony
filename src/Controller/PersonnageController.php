<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Form\PersonnageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
    /**
     * @Route("/personnage", name="personnage_")
     */
class PersonnageController extends AbstractController
{

    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $personnages = $repo->findBy(array('joueur' => $user->getId()), array('nom' => 'ASC'));
        return $this->render('personnage/list.html.twig', [
            "personnages" => $personnages
        ]);
    }

    /**
     * @Route("/creation", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personnage = new Personnage();
        $personnageForm = $this->createForm(PersonnageType::class, $personnage);

        /* dd($personnageForm); */
         $personnageForm->handleRequest($request);
            dump($personnage);
         /*if($personnageForm->isSubmitted()){
            $entityManager->persist($personnage);
            $entityManager->flush();
            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirect('personnage_view');
        } */
        return $this->render('personnage/creation.html.twig', [
            "personnageForm" => $personnageForm->createView()
        ]);
    }
 /**
     * @Route("/{id}", name="view")
     */
    public function index($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        return $this->render('personnage/index.html.twig',[
            'personnage' => $personnage
        ]);
    }
    
}
