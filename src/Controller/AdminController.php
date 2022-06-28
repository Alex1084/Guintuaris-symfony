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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
}
