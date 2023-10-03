<?php

namespace App\Controller\Admin;

use App\Entity\Bestiary;
use App\Entity\BestiaryType;
use App\Form\BestiaryFormType;
use App\Form\NameFormType;
use App\Repository\BestiaryRepository;
use App\Repository\BestiaryTypeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/bestiaire', name: 'admin_')]
class BestiaryController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/ajouter-creature', name: 'add_bestiary')]
    public function addBestiary(
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $bestiary = new Bestiary();
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $bestiary->setPv($bestiary->getPvMax())
                ->setPc($bestiary->getPcMax())
                ->setPm($bestiary->getPmMax())
                ->setcreatedAt(new DateTimeImmutable());
            $entityManager->persist($bestiary);
            $entityManager->flush();
            $this->addFlash("success", "La créature a été enregistrée dans le bestiaire.");
            return $this->redirectToRoute("admin_bestiary_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/liste', name: 'bestiary_list')]
    public function bestiaryList(BestiaryRepository $bestiaryRepository): Response
    {
        $creatures = $bestiaryRepository->bestiaryList();
        return $this->render('admin/bestiary/list.html.twig', [
            'creatures' => $creatures
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/modifier-creature/{bestiaryId}', name: 'update_bestiary')]
    public function updateBestiary(
        int $bestiaryId,
        Request $request,
        EntityManagerInterface $entityManager,
        BestiaryRepository $bestiaryRepository): Response
    {
        $bestiary = $bestiaryRepository->find($bestiaryId);
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $bestiary->setPv($bestiary->getPvMax())
                 ->setPc($bestiary->getPcMax())
                 ->setPm($bestiary->getPmMax());
            $entityManager->persist($bestiary);
            $entityManager->flush();
            $this->addFlash("success", "La créature a été modifiée avec succès.");
            return $this->redirectToRoute("admin_bestiary_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }

    /**
     * 
     */
    #[Route('/supprimer-creature/{bestiaryId}', name: 'delete_bestiary')]
    public function deleteBestiary(
        int $bestiaryId,
        EntityManagerInterface $entityManager,
        BestiaryRepository $bestiaryRepository)
    {
        $bestiary = $bestiaryRepository->find($bestiaryId);
            $entityManager->remove($bestiary);
            $entityManager->flush();
            return $this->json("Supprimé avec succès");
    }

    /**
     * permet d'ajouter un nouveau type de bete dans la base de donné (table type_bestiaire)
     * affiche toute les instance se trouvant dans cette table
     */
    #[Route("/liste-type-bestiaire", name:"bestiary_type_list")]
    public function addBestiaryType(
        Request $request,
        EntityManagerInterface $entityManager,
        BestiaryTypeRepository $bestiaryTypeRepository): Response
    {
        $newType = new BestiaryType();

        $findall = $bestiaryTypeRepository->findBy([], ["name" => "ASC"]);
        $form = $this->createForm(NameFormType::class, $newType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newType);
            $entityManager->flush();
            $this->addFlash("success", "Le type ".$newType->getName()."a été enregistré.");
            return $this->redirectToRoute('admin_bestiary_type_list');
        }
        return $this->render('admin/bestiary/typeList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }
    #[Route("/modifier-type-bestiaire/{typeId}", name:"bestiary_type_rename")]
    public function teamRename(
        int $typeId,
        Request $request,
        EntityManagerInterface $entityManager,
        BestiaryTypeRepository $bestiaryTypeRepository): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3 || strlen($newName) > 50 ) {
                $this->addFlash("error", "Le nom entré n'est pas valide, il doit faire entre 3 et 50 caractères.");
                return $this->redirectToRoute("admin_bestiary_type_list");
            }
            $type = $bestiaryTypeRepository->find($typeId);
            $oldname = $type->getName();
            $type->setName($newName);
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", "Le type ".$oldname." a été renommé ".$newName.".");
        }
        return $this->redirectToRoute("admin_bestiary_type_list");
    }
}
