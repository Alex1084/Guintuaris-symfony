<?php

namespace App\Controller;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Entity\Bestiaire;
use App\Entity\Character;
use App\Entity\Competence;
use App\Entity\Equipe;
use App\Entity\TypeBestiaire;
use App\Entity\Weapon;
use App\Form\ArmorPieceType;
use App\Form\BestiaireType;
use App\Form\CompetenceType;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * affiche le lien des pour acceder au fonctionaliter administrateur
     * 
     * @Route("/", name="home")
     * 
     * @return Response
     */
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', []);
    }


    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     * 
     * @Route("/add_competence", name="add_competence")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function competence(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competence = new Competence();
        $competenceForm = $this->createForm(CompetenceType::class, $competence);

        $competenceForm->handleRequest($request);
        if ($competenceForm->isSubmitted()) {

            $entityManager->persist($competence);
            $entityManager->flush();
        }
        return $this->render('admin/addcompetence.html.twig', [
            "competenceForm" => $competenceForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvel Piece d'armure dans la BDD (table armor_piece)
     * permet aussi d'afficher toute les instance de cette table
     * 
     * @Route("/ajout_piece", name="add_piece")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(ArmorPiece::class);
        $piecesTab = $repo->findAll();
        $piece = new ArmorPiece();
        $pieceForm = $this->createForm(ArmorPieceType::class, $piece);

        $pieceForm->handleRequest($request);
        if ($pieceForm->isSubmitted()) {
            $entityManager->persist($piece);
            $entityManager->flush();

            return $this->redirectToRoute('admin_add_piece');
        }
        return $this->render('admin/addPiece.html.twig', [
            "pieceForm" => $pieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }
    /**
     * affiche dans un select tout les personnage present dans l'equipe aucune
     * lorsque le formulaire est valider le persnnage selectioner changer d'equipe et a pour equipe celle selectionner dans la page admin_equipe_list
     * de plus la page affiche le nom de tout les personnage apartenent a l'equipe (les nom emmenent ensuite vers leur fiche)
     * 
     * @Route("/ajout_membre/{idEquipe}", name="add_membre")
     *
     * @param int $idEquipe
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addMembreEquipe(int $idEquipe, Request $request, EntityManagerInterface $entityManager): Response
    {
        $membresEquipe = $this->getDoctrine()->getRepository(Character::class)->findBy(['equipe' => $idEquipe]); //list des Memebre apartennant a cette equipe
        $equipeJoin = $this->getDoctrine()->getRepository(Equipe::class)->find($idEquipe); //represente la L'equipe sur la quelle des membre vont etre ajouter
        $memberForm = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'nom',
                'query_builder' => function (CharacterRepository $pr) {
                    return $pr->createQueryBuilder('c')
                        ->where('c.team = 5') //si l'equipe choisi est 5 (aucune), alors on recherche tout les joueurs apparteant a une Equipe 
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->getForm();
        $memberForm->handleRequest($request);
        if ($memberForm->isSubmitted()) {
            $characterSelectionner = $memberForm->get('personnage')->getData();
            $characterSelectionner->setEquipe($equipeJoin);
            dump($characterSelectionner);

            $entityManager->persist($characterSelectionner);
            $entityManager->flush();
            return $this->redirectToRoute('admin_add_membre', ['idEquipe' => $idEquipe]);
        }
        return $this->render('admin/addMembreEquipe.html.twig', [
            'memberForm' => $memberForm->createView(),
            'membresEquipe' => $membresEquipe,
        ]);
    }

    /**
     * permet d'ajouter une bete dans la base de donnée  (table bestiaire)
     * 
     * @Route("/bestiaire", name="add_bete")
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function addBete(EntityManagerInterface $entityManager, Request $request): Response
    {
        $bete = new Bestiaire();
        $beteForm = $this->createForm(BestiaireType::class, $bete);

        $beteForm->handleRequest($request);
        if ($beteForm->isSubmitted()) {
            $bete->setPv($bete->getPvMax())
                 ->setPc($bete->getPcMax())
                 ->setPm($bete->getPmMax());

            $entityManager->persist($bete);
            $entityManager->flush();
            return $this->redirectToRoute("admin_add_bete");
        }
        return $this->render('admin/addBete.html.twig', [
            "beteForm" => $beteForm->createView(),
        ]);
    }
    /**
     * permet d'ajouter un nouveau type de bete dans la base de donné (table type_bestiaire)
     * affiche toute les instance se trouvant dans cette table
     * 
     * @Route("/list_type_bestiaire", name="type_bestiaire_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addTypeBestiaire(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newType = new TypeBestiaire();

        $results = $this->createFormTable($newType, $request, $entityManager);

        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_type_bestiaire_list');
        }
        //dd($results['formulaire']);
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView()
        ]);
    }


    /**
     * affiche le nom de toute les equipe et emment ensuite vers admin_add_membre
     * de plus un formulaire permet de créer une nouvelle equipe
     *
     *  @Route("/equipe", name="equipe_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function listEquipeAdmin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newEquipe = new Equipe();
        $results = $this->createFormTable($newEquipe, $request, $entityManager);
        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute("admin_add_membre", ['idEquipe' => $newEquipe->getId()]);
        }
        return $this->render('admin/listEquipe.html.twig', [
            'equipes' => $results['dataList'],
            'addEquipeForm' => $results['formulaire']->createView()
        ]);
    }
    /**
     * permet d'ajouter un nouveau type d'armure dans la base de donné (table armor_type)
     * affiche toute les instance se trouvant dans cette table
     *
     *  @Route("/list_type_armure", name="type_armure_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addArmorType(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newType = new ArmorType();
        $results = $this->createFormTable($newType, $request, $entityManager);
        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_type_armure_list');
        }
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView()
        ]);
    }
    /**
     *
     *  @Route("/list_localisation_armure", name="localisation_armure_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addArmorLocation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newLoca = new ArmorLocation();
        $results = $this->createFormTable($newLoca, $request, $entityManager);
        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_type_armure_list');
        }
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView()
        ]);
    }


    /**
     * 
     * @Route("/list_arme", name="arme_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addWeapon(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newWeapon = new Weapon();
        $results = $this->createFormTable($newWeapon, $request, $entityManager);
        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_arme_list');
        }
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView()
        ]);
    }


    /**
     * Undocumented function
     *
     * @param Object $objet
     * @param string $class
     */
    private function createFormTable(Object $objet, Request $request, EntityManagerInterface $entityManager)
    {
        $repo = $this->getDoctrine()->getRepository(get_class($objet));
        $findall = $repo->findAll();
        $form = $this->createFormBuilder($objet)
            ->add('name', TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($objet);
            $entityManager->flush();
        }

        $array = ['dataList' => $findall, 'formulaire' => $form];
        return $array;
    }
}
