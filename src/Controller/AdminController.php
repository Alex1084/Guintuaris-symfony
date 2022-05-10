<?php

namespace App\Controller;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Entity\Bestiary;
use App\Entity\BestiaryType;
use App\Entity\Character;
use App\Entity\Skill;
use App\Entity\Team;
use App\Entity\Weapon;
use App\Form\ArmorPieceType;
use App\Form\BestiaryFormType;
use App\Form\SkillFormType;
use App\Repository\ArmorPieceRepository;
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
     */
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', []);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     * 
     * @Route("/add-competence", name="add_skill")
     *
     */
    public function addSkill(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill();
        $skillForm = $this->createForm(SkillFormType::class, $skill);

        $skillForm->handleRequest($request);
        if ($skillForm->isSubmitted()) {

            $entityManager->persist($skill);
            $entityManager->flush();
        }
        return $this->render('admin/addcompetence.html.twig', [
            "skillForm" => $skillForm->createView()
        ]);
    }

    /**
     * permet d'ajouter une nouvel Piece d'armure dans la BDD (table armor_piece)
     * permet aussi d'afficher toute les instance de cette table
     * 
     * @Route("/ajout-piece-d-armure", name="add_armor_piece")
     *
     */
    public function addArmorPiece(Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $armorPieceRepository): Response
    {
        $piecesTab = $armorPieceRepository->selectAllNamesValue();
        $armorPiece = new ArmorPiece();
        $armorPieceForm = $this->createForm(ArmorPieceType::class, $armorPiece);

        $armorPieceForm->handleRequest($request);
        if ($armorPieceForm->isSubmitted()) {
            $entityManager->persist($armorPiece);
            $entityManager->flush();

            return $this->redirectToRoute('admin_add_armor_piece');
        }
        return $this->render('admin/addPiece.html.twig', [
            "armorPieceForm" => $armorPieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }

    /**
     * affiche dans un select tout les personnage present dans l'equipe aucune
     * lorsque le formulaire est valider le persnnage selectioner changer d'equipe et a pour equipe celle selectionner dans la page admin_equipe_list
     * de plus la page affiche le nom de tout les personnage apartenent a l'equipe (les nom emmenent ensuite vers leur fiche)
     * 
     * @Route("/ajout-membre/{teamId}", name="add_member")
     *
     */
    public function addTeamMember(int $teamId, Request $request, EntityManagerInterface $entityManager, CharacterRepository $characterRepository): Response
    {
        $teamMembers = $characterRepository->findNameByTeam($teamId); //list des Memebre apartennant a cette equipe
        $team = $this->getDoctrine()->getRepository(Team::class)->find($teamId); //represente la L'equipe sur la quelle des membre vont etre ajouter
        $memberForm = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'query_builder' => function (CharacterRepository $pr) {
                    return $pr->createQueryBuilder('c')
                        ->where('c.team = 5') //si l'equipe choisi est 5 (aucune), alors on recherche tout les joueurs apparteant a une Equipe 
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->getForm();
        $memberForm->handleRequest($request);
        if ($memberForm->isSubmitted()) {
            $characterSelectionner = $memberForm->get('character')->getData();
            $characterSelectionner->setTeam($team);
            dump($characterSelectionner);

            $entityManager->persist($characterSelectionner);
            $entityManager->flush();
            return $this->redirectToRoute('admin_add_member', ['teamId' => $teamId]);
        }
        return $this->render('admin/addMembreEquipe.html.twig', [
            'memberForm' => $memberForm->createView(),
            'teamId' => $teamId,
            'teamMembers' => $teamMembers,
        ]);
    }

    /**
     * permet d'ajouter une bete dans la base de donnée  (table bestiaire)
     * 
     * @Route("/bestiaire", name="add_creature")
     *
     */
    public function addCreature(EntityManagerInterface $entityManager, Request $request): Response
    {
        $creature = new Bestiary();
        $creatureForm = $this->createForm(BestiaryFormType::class, $creature);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted()) {
            $creature->setPv($creature->getPvMax())
                 ->setPc($creature->getPcMax())
                 ->setPm($creature->getPmMax());

            $entityManager->persist($creature);
            $entityManager->flush();
            return $this->redirectToRoute("admin_add_creature");
        }
        return $this->render('admin/addBete.html.twig', [
            "creatureForm" => $creatureForm->createView(),
        ]);
    }

    /**
     * 
     * @Route("/liste-armes", name="weapon_list")
     *
     */
    public function addWeapon(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newWeapon = new Weapon();
        $results = null;
        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_arme_list');
        }
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView()
        ]);
    }
}
