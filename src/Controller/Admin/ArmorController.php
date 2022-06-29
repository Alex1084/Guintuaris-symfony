<?php

namespace App\Controller\Admin;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Form\ArmorPieceType;
use App\Repository\ArmorPieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name:"admin_")]
class ArmorController extends AbstractController
{
    /**
     * Undocumented function
     */
    #[Route("/list-localisation-armure", name:"armor_location_list")]
    public function addArmorLocation(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newLoca = new ArmorLocation();
        $findall = $doctrine->getRepository(ArmorLocation::class)->findAll();
        $form = $this->createFormBuilder($newLoca)
            ->add('name', TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($newLoca);
            $entityManager->flush();
        }
        if ($form->isSubmitted()) {
            return $this->redirectToRoute('admin_armor_location_list');
        }
        return $this->render('admin/armor/locationList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/update-localisation-armure/{locationId}", name:"armor_location_update")]
    public function updatedArmorLocation(int $locationId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2) {
                return $this->redirectToRoute('admin_armor_location_list');
            }
            $location = $doctrine->getRepository(ArmorLocation::class)->find($locationId);
            $location->setName($newName);
            $entityManager->persist($location);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_armor_location_list');
    }

    #[Route("/list-type-armure", name:"armor_type_list")]
    public function addArmorType(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newLoca = new ArmorType();
        $findall = $doctrine->getRepository(ArmorType::class)->findAll();
        $form = $this->createFormBuilder($newLoca)
            ->add('name', TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($newLoca);
            $entityManager->flush();
        }
        if ($form->isSubmitted()) {
            return $this->redirectToRoute('admin_armor_type_list');
        }
        return $this->render('admin/armor/typeList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/update-type-armure/{typeId}", name:"armor_type_update")]
    public function updatedArmorType(int $typeId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2) {
                return $this->redirectToRoute('admin_armor_type_list');
            }
            $type = $doctrine->getRepository(ArmorType::class)->find($typeId);
            $type->setName($newName);
            $entityManager->persist($type);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_armor_type_list');
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
        return $this->render('admin/armor/pieceList.html.twig', [
            "armorPieceForm" => $armorPieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }

    #[Route('/update-piece-d-armure/{pieceId}', name: 'update_armor_piece')]
    public function updateArmorPieceValue(int $pieceId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        if ($request->isMethod('post')) {
            $newValue = $request->request->get('value');
            if (gettype($newValue) === "integer") {
                return $this->redirectToRoute('admin_add_armor_piece');
            }
            $piece = $doctrine->getRepository(ArmorPiece::class)->find($pieceId);
            $piece->setValue($newValue);
            $entityManager->persist($piece);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_add_armor_piece');
    }
}
