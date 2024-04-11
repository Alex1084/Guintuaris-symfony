<?php

namespace App\Controller\Admin;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Form\ArmorPieceType;
use App\Form\NameFormType;
use App\Repository\ArmorLocationRepository;
use App\Repository\ArmorPieceRepository;
use App\Repository\ArmorTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route("/administration/armure", name:"admin_")]
class ArmorController extends AbstractController
{
    /**
     * Undocumented function
     */
    #[Route("/liste-localisation", name:"armor_location_list")]
    public function addArmorLocation(
        Request $request, 
        EntityManagerInterface $entityManager,
        ArmorLocationRepository $armorLocationRepository,
        SluggerInterface $slugger
        ): Response
    {
        $newLoca = new ArmorLocation();
        $findall = $armorLocationRepository->findBy([], ["id" => "ASC"]);
        $form = $this->createForm(NameFormType::class, $newLoca);
        $form->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $newLoca->setVarName($slugger->slug($newLoca->getName()));
                $entityManager->persist($newLoca);
                $entityManager->flush();
                $this->addFlash("success", "La localisation d'armure a été ajoutée. Pour le moment, aucune pièce d'armure n'est associée à cette localisation, pensez à créer des pièces d'armure.");
                return $this->redirectToRoute('admin_armor_location_list');
            }
            else {
                $this->addFlash("error", "Le formulaire n'a pas été rempli correctement, veuillez affichez le formulaire.");
            }
        }
        return $this->render('admin/armor/locationList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/modifier-localisation/{locationId}", name:"armor_location_update")]
    public function updatedArmorLocation(
        int $locationId,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        ArmorLocationRepository $armorLocationRepository): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2 || strlen($newName) > 50) {
                $this->addFlash("error", "Le nom entré n'est pas valide, il doit faire entre 2 et 50 caractères.");
                return $this->redirectToRoute('admin_armor_location_list');
            }
            $location = $armorLocationRepository->find($locationId);
            $oldName = $location->getName();
            $location->setName($newName);
            $location->setVarName($slugger->slug($location->getName()));
            $entityManager->persist($location);
            $entityManager->flush();
            $this->addFlash("success", "La localisation ". $oldName." a été renommé ". $newName.".");
        }
        return $this->redirectToRoute('admin_armor_location_list');
    }

    #[Route("/liste-type", name:"armor_type_list")]
    public function addArmorType(
        Request $request,
        EntityManagerInterface $entityManager,
        ArmorTypeRepository $armorTypeRepository): Response
    {
        $newLoca = new ArmorType();
        $findall = $armorTypeRepository->findBy([], ["id" => "ASC"]);
        $form = $this->createForm(NameFormType::class, $newLoca);
        $form->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($newLoca);
                $entityManager->flush();
                $this->addFlash("success", "Le type d'armure a été ajouté. Pour le moment, aucune pièce d'armure n'est associée à ce type, pensez à créer des pièces d'armure.");
                return $this->redirectToRoute('admin_armor_type_list');
            }
            else {
                $this->addFlash("error", "Le formulaire n'a pas été rempli correctement, veuillez affichez le formulaire.");
            }
        }
        return $this->render('admin/armor/typeList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/modifier-type/{typeId}", name:"armor_type_update")]
    public function updatedArmorType(
        int $typeId,
        Request $request,
        EntityManagerInterface $entityManager,
        ArmorTypeRepository $armorTypeRepository): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2 || strlen($newName) > 50 ) {
                $this->addFlash("error", "Le nom entré n'est pas valide, il doit faire entre 2 et 50 caractères.");
                return $this->redirectToRoute('admin_armor_type_list');
            }
            $type = $armorTypeRepository->find($typeId);
            $oldName = $type->getName();
            $type->setName($newName);
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", "La localisation ". $oldName." a été renommée ". $newName .".");
        }
        return $this->redirectToRoute('admin_armor_type_list');
    }

    /**
     * permet d'ajouter une nouvel Piece d'armure dans la BDD (table armor_piece)
     * permet aussi d'afficher toute les instance de cette table
     */
    #[Route('/pieces-d-armures', name: 'armor_pieces')]
    public function addArmorPiece(ArmorPieceRepository $armorPieceRepository): Response
    {
        $piecesTab = $armorPieceRepository->selectAllNamesValue();
        return $this->render('admin/armor/pieceList.html.twig', [
            "piecesTab" => $piecesTab
        ]);
    }

    /**
     * 
     */
    #[Route('/ajouter-piece', name: 'add_armor_piece')]
    public function FunctionName(
        Request $request,
        EntityManagerInterface $entityManager,
    )
    {
        $armorPiece = new ArmorPiece();
        $armorPieceForm = $this->createForm(ArmorPieceType::class, $armorPiece);

        $armorPieceForm->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($armorPieceForm->isSubmitted() && $armorPieceForm->isValid()) {
                $entityManager->persist($armorPiece);
                $entityManager->flush();
                $this->addFlash("success", "La nouvelle pièce d'armure a été enregistrée.");
                return $this->redirectToRoute('admin_add_armor_piece');
            }
            else {
                $this->addFlash("error", "Le formulaire n'a pas été rempli correctement, veuillez affichez le formulaire.");
            }
        }
        $piecesTab = $armorPieceRepository->selectAllNamesValue();
        return $this->render('admin/armor/pieceList.html.twig', [
            "armorPieceForm" => $armorPieceForm->createView(),
        ]);
    }
    #[Route('/modifier-piece/{pieceId}', name: 'update_armor_piece')]
    public function updateArmorPieceValue(
        int $pieceId, Request $request,
        EntityManagerInterface $entityManager,
        ArmorPieceRepository $armorPieceRepository)
    {
        if ($request->isMethod('post')) {
            $newValue = $request->request->get('value');
            if (gettype($newValue) === "integer" && $newValue >= 0 && $newValue <= 10) {
                $this->addFlash("error", "La valeur de classe d'armure n'est pas valide, veuillez entrer un nombre entier entre 1 et 10.");
                return $this->redirectToRoute('admin_add_armor_piece');
            }
            $piece = $armorPieceRepository->find($pieceId);
            $piece->setValue($newValue);
            $entityManager->persist($piece);
            $entityManager->flush();
            $this->addFlash("success", "La pièce d'armure a été mise à jour.");
        }
        return $this->redirectToRoute('admin_add_armor_piece');
    }
}
