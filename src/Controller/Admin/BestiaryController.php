<?php

namespace App\Controller\Admin;

use App\Entity\Bestiary;
use App\Entity\BestiaryType;
use App\Form\BestiaryFormType;
use App\Form\NameFormType;
use App\Repository\BestiaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class BestiaryController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/ajouter-creature', name: 'add_bestiary')]
    public function addBestiary(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bestiary = new Bestiary();
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $bestiary->setPv($bestiary->getPvMax())
                ->setPc($bestiary->getPcMax())
                ->setPm($bestiary->getPmMax());
            $entityManager->persist($bestiary);
            $entityManager->flush();

            return $this->redirectToRoute("admin_bestiary_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/creature-list', name: 'bestiary_list')]
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
    public function updateBestiary(int $bestiaryId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $bestiary = $doctrine->getRepository(Bestiary::class)->find($bestiaryId);
        $creatureForm = $this->createForm(BestiaryFormType::class, $bestiary);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $bestiary->setPv($bestiary->getPvMax())
                 ->setPc($bestiary->getPcMax())
                 ->setPm($bestiary->getPmMax());
            $entityManager->persist($bestiary);
            $entityManager->flush();
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
    public function deleteBestiary(int $bestiaryId, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $bestiary = $doctrine->getRepository(Bestiary::class)->find($bestiaryId);
            $entityManager->remove($bestiary);
            $entityManager->flush();
            return $this->json("delete Succes");
    }

    /**
     * permet d'ajouter un nouveau type de bete dans la base de donné (table type_bestiaire)
     * affiche toute les instance se trouvant dans cette table
     */
    #[Route("/list-type-bestiaire", name:"bestiary_type_list")]
    public function addBestiaryType(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newType = new BestiaryType();

        $findall = $doctrine->getRepository(BestiaryType::class)->findAll();
        $form = $this->createForm(NameFormType::class, $newType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newType);
            $entityManager->flush();
            return $this->redirectToRoute('admin_bestiary_type_list');
        }
        return $this->render('admin/listTable.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }
    #[Route("/update-type-bestiaire/{typeId}", name:"bestiary_type_rename")]
    public function teamRename(int $typeId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3 || strlen($newName) > 50 ) {
                return $this->redirectToRoute("admin_bestiary_type_list");
            }
            $team = $doctrine->getRepository(BestiaryType::class)->find($typeId);
            $team->setName($newName);
            $entityManager->persist($team);
            $entityManager->flush();
        }
        return $this->redirectToRoute("admin_bestiary_type_list");
    }
}
