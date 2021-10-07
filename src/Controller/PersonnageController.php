<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\Equipe;
use App\Form\PersonnageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            // hydratation des champs 
            $personnage->setLore("");
             $personnage->setInventaire("");
             $personnage->setPo(0);
             $personnage->setJoueur($this->getUser());
             $personnage->setPv($personnage->getPvMax());
             $personnage->setPm($personnage->getPmMax());
             $personnage->setPc($personnage->getPcMax());
             $personnage->setEquipe($equipe);
            //

            // execution de la requete
            $entityManager->persist($personnage);
            $entityManager->flush();
            //

            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_list');
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
            'personnage' => $personnage,
        ]);
    }
    /**
     * @Route("/{id}/lore", name="modif_lore")
     */
    public function lore($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $loreForm = $this->createFormBuilder($personnage)
                    ->add('lore', TextareaType::class)
                    ->getForm();
        $loreForm->handleRequest($request);
        if($loreForm->isSubmitted()){
        dump($personnage);

        // execution de la requete
        $entityManager->persist($personnage);
        $entityManager->flush();
        //
        return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/lore.html.twig', [
            "loreForm" => $loreForm->createView()
        ]);
    }

    /**
     * @Route("/{id}/level_up", name="level_up")
     */
    public function levulUp($id, Request $request, EntityManagerInterface $entityManager){

        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $personnageForm = $this->createForm(PersonnageType::class, $personnage);
        dump($personnage);

        //annulation affichage champs hors formulaire
        $personnageForm->remove('nom');
        $personnageForm->remove('lore');
        $personnageForm->remove('inventaire');
        $personnageForm->remove('po');
        $personnageForm->remove('joueur');
        $personnageForm->remove('pv');
        $personnageForm->remove('pc');
        $personnageForm->remove('pm');
        $personnageForm->remove('classe');
        $personnageForm->remove('race');

        $personnageForm->handleRequest($request);
        if($personnageForm->isSubmitted()){
            // hydratation des champs 
             $personnage->setPv($personnage->getPvMax());
             $personnage->setPm($personnage->getPmMax());
             $personnage->setPc($personnage->getPcMax());
            //
            // execution de la requete
            $entityManager->persist($personnage);
            $entityManager->flush();
            //

            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/levelup.html.twig', [
            "personnageForm" => $personnageForm->createView()
        ]);
    }
}
