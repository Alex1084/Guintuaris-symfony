<?php

namespace App\Controller;

use App\Entity\Bestiaire;
use App\Entity\Competence;
use App\Entity\Equipe;
use App\Entity\Personnage;
use App\Entity\PieceArmure;
use App\Form\BestiaireType;
use App\Form\CompetenceType;
use App\Form\PieceArmureType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\EntityListeners;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     * @Route("/ajout_membre/{idEquipe}", name="add_membre")
     */
    public function addMembreEquipe($idEquipe, Request $request, EntityManagerInterface $entityManager){
        $equipeJoin = $this->getDoctrine()->getRepository(Equipe::class)->find($idEquipe);
        $membre = $this->createFormBuilder()
                        ->add('personnage', EntityType::class,[
                            'class' => Personnage::class,
                            'choice_label' => 'nom',
                            'query_builder' => function (PersonnageRepository $pr){
                                return $pr->createQueryBuilder('p')
                                            ->where('p.equipe = 5')
                                            ->orderBy('p.nom', 'ASC');
                            }
                        ])
                        ->getForm();
        $membre->handleRequest($request);
        if($membre->isSubmitted()){
            $personnageSelectionner = $membre->get('personnage')->getData();
            $personnageSelectionner->setEquipe($equipeJoin);
            dump($personnageSelectionner);

            $entityManager->persist($personnageSelectionner);
            $entityManager->flush();
            return $this->redirectToRoute('admin_add_membre');
        }
        return $this->render('admin/addMembreEquipe.html.twig', [
            'membre' => $membre->createView(),
        ]);
    }

    /**
     * @Route("/equipe", name="equipe_list")
     */
    public function listEquipeAdmin(){
        $repo = $this->getDoctrine()->getRepository(Equipe::class);
        $equipes = $repo->findAll();
        return $this->render('admin/listEquipe.html.twig', [
            'equipes' => $equipes,
        ]);
    }

    /**
     * @Route("/Bestiaire", name="add_bete")
     */
    public function addBete(EntityManagerInterface $entityManager, Request $request){
        $bete = new Bestiaire();
        $beteForm = $this->createForm(BestiaireType::class, $bete);

        $beteForm->remove('pv');
        $beteForm->remove('pc');
        $beteForm->remove('pm');
        $beteForm->handleRequest($request);
        if($beteForm->isSubmitted()){
            $bete->setPv($bete->getPvMax());
            $bete->setPc($bete->getPcMax());
            $bete->setPm($bete->getPmMax());

            dump($bete);
            $entityManager->persist($bete);
            $entityManager->flush();
        }
        return $this->render('admin/addBete.html.twig', [
            "beteForm" => $beteForm->createView(),
        ]);
    }
}
