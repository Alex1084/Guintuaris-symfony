<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\Equipe;
use App\Form\PersonnageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

        // requete pour recuperer l'equipe n°5  nom -> aucune
        $id = 5;
        $repo = $this->getDoctrine()->getRepository(Equipe::class);
        $equipe = $repo->find($id);


        $personnage = new Personnage();
        $personnageForm = $this->createForm(PersonnageType::class, $personnage);

        //annulation affichage champs hors formulaire
        $personnageForm->remove('lore');
        $personnageForm->remove('inventaire');
        $personnageForm->remove('po');
        $personnageForm->remove('joueur');
        $personnageForm->remove('pv');
        $personnageForm->remove('pc');
        $personnageForm->remove('pm');
        
        //
         $personnageForm->handleRequest($request);
         if($personnageForm->isSubmitted()){
             $personnage->setLore("");
             $personnage->setInventaire("");
             $personnage->setPo(0);
             $personnage->setJoueur($this->getUser());
             $personnage->setPv($personnage->getPvMax());
             $personnage->setPm($personnage->getPmMax());
             $personnage->setPc($personnage->getPcMax());
             $personnage->setEquipe($equipe);
            $entityManager->persist($personnage);
            $entityManager->flush();
            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirect('personnage_list');
        }
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
