<?php

namespace App\Controller;

use App\Entity\ArmorPiece;
use App\Entity\Character;
use App\Entity\Team;
use App\Form\ArmorPieceType;
use App\Repository\ArmorPieceRepository;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{

    /**
     * affiche le lien des pour acceder au fonctionaliter administrateur
     *
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function adminHome(): Response
    {
        return $this->render('admin/admin.html.twig', []);
    }

    /**
     * permet d'ajouter une nouvel Piece d'armure dans la BDD (table armor_piece)
     * permet aussi d'afficher toute les instance de cette table
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ArmorPieceRepository $armorPieceRepository
     * @return Response
     */
    #[Route('/ajout-piece-d-armure', name: 'add_armor_piece')]
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
     *
     * @param integer $teamId
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CharacterRepository $characterRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/ajout-membre/{teamId}', name: 'add_member')]
    public function addTeamMember(int $teamId, Request $request, EntityManagerInterface $entityManager, CharacterRepository $characterRepository, ManagerRegistry $doctrine): Response
    {
        $teamMembers = $characterRepository->findNameByTeam($teamId); //list des Memebre apartennant a cette equipe
        $team = $doctrine->getRepository(Team::class)->find($teamId); //represente la L'equipe sur la quelle des membre vont etre ajouter
        $memberForm = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'query_builder' => function (CharacterRepository $pr) {
                    return $pr->createQueryBuilder('c')
                        ->where('c.team IS NULL')
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
}
