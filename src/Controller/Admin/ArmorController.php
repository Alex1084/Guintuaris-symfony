<?php

namespace App\Controller\Admin;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Form\ArmorPieceType;
use App\Form\NameFormType;
use App\Repository\ArmorPieceRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/administration/armure", name:"admin_")]
class ArmorController extends AbstractController
{
    /**
     * Undocumented function
     */
    #[Route("/liste-localisation", name:"armor_location_list")]
    public function addArmorLocation(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newLoca = new ArmorLocation();
        $findall = $doctrine->getRepository(ArmorLocation::class)->findAll();
        $form = $this->createForm(NameFormType::class, $newLoca);
        $form->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $slugify = new Slugify();
                $newLoca->setVarName($slugify->slugify($newLoca->getName()));
                $entityManager->persist($newLoca);
                $entityManager->flush();
                $this->addFlash("success", "la localisation d'armure a été ajouter. Pour le moment aucune piece d'armure ne sont associer a cette localisation, pensez à crée des pieces.");
                return $this->redirectToRoute('admin_armor_location_list');
            }
            else {
                $this->addFlash("error", "le formulaire n'as pas été rempli correctement, affichez le formulaire");
            }
        }
        return $this->render('admin/armor/locationList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/modifier-localisation/{locationId}", name:"armor_location_update")]
    public function updatedArmorLocation(int $locationId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2 || strlen($newName) > 50) {
                $this->addFlash("error", "le nom entré n'est pas valide, il doit faire entre 2 et 50 caractère");
                return $this->redirectToRoute('admin_armor_location_list');
            }
            $location = $doctrine->getRepository(ArmorLocation::class)->find($locationId);
            $oldName = $location->getName();
            $location->setName($newName);
            $slugify = new Slugify();
            $location->setVarName($slugify->slugify($location->getName()));
            $entityManager->persist($location);
            $entityManager->flush();
            $this->addFlash("success", "la localisation ". $oldName." a été renommé ". $newName);
        }
        return $this->redirectToRoute('admin_armor_location_list');
    }

    #[Route("/liste-type", name:"armor_type_list")]
    public function addArmorType(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newLoca = new ArmorType();
        $findall = $doctrine->getRepository(ArmorType::class)->findAll();
        $form = $this->createForm(NameFormType::class, $newLoca);
        $form->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($newLoca);
                $entityManager->flush();
                $this->addFlash("success", "le type d'armure a été ajouter. Pour le moment aucune piece d'armure ne sont associer a ce type, pensez à crée des pieces.");
                return $this->redirectToRoute('admin_armor_type_list');
            }
            else {
                $this->addFlash("error", "le formulaire n'as pas été rempli correctement, affichez le formulaire");
            }
        }
        return $this->render('admin/armor/typeList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }

    #[Route("/modifier-type/{typeId}", name:"armor_type_update")]
    public function updatedArmorType(int $typeId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get('value');
            if (strlen($newName) <= 2 || strlen($newName) > 50 ) {
                $this->addFlash("error", "le nom entré n'est pas valide, il doit faire entre 2 et 50 caractère");
                return $this->redirectToRoute('admin_armor_type_list');
            }
            $type = $doctrine->getRepository(ArmorType::class)->find($typeId);
            $oldName = $type->getName();
            $type->setName($newName);
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", "la localisation ". $oldName." a été renommé ". $newName);
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
    #[Route('/ajouter-piece', name: 'add_armor_piece')]
    public function addArmorPiece(Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $armorPieceRepository): Response
    {
        $piecesTab = $armorPieceRepository->selectAllNamesValue();
        $armorPiece = new ArmorPiece();
        $armorPieceForm = $this->createForm(ArmorPieceType::class, $armorPiece);

        $armorPieceForm->handleRequest($request);
        if ($request->isMethod("post")) {
            if ($armorPieceForm->isSubmitted() && $armorPieceForm->isValid()) {
                $entityManager->persist($armorPiece);
                $entityManager->flush();
                $this->addFlash("success", "la novelle piece d'armure a été enregistrée");
                return $this->redirectToRoute('admin_add_armor_piece');
            }
            else {
                $this->addFlash("error", "le formulaire n'as pas été rempli correctement, affichez le formulaire");
            }
        }
        return $this->render('admin/armor/pieceList.html.twig', [
            "armorPieceForm" => $armorPieceForm->createView(),
            "piecesTab" => $piecesTab
        ]);
    }

    #[Route('/modifier-piece/{pieceId}', name: 'update_armor_piece')]
    public function updateArmorPieceValue(int $pieceId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        if ($request->isMethod('post')) {
            $newValue = $request->request->get('value');
            if (gettype($newValue) === "integer" && $newValue >= 0 && $newValue <= 10) {
                $this->addFlash("error", "veuillez entré un nombre entier entre 1 et 10");
                return $this->redirectToRoute('admin_add_armor_piece');
            }
            $piece = $doctrine->getRepository(ArmorPiece::class)->find($pieceId);
            $piece->setValue($newValue);
            $entityManager->persist($piece);
            $entityManager->flush();
            $this->addFlash("success", "la piece d'armure a été mise a jour");
        }
        return $this->redirectToRoute('admin_add_armor_piece');
    }
}
