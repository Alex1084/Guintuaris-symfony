<?php

namespace App\Controller\Admin;

use App\Entity\Creature;
use App\Entity\CreatureType;
use App\Form\CreatureFormType;
use App\Form\NameFormType;
use App\Repository\CreatureRepository;
use App\Repository\CreatureTypeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/bestiaire', name: 'admin_')]
class CreatureController extends AbstractController
{
     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/ajouter-creature', name: 'add_creature')]
    public function addCreature(
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $creature = new Creature();
        $creatureForm = $this->createForm(CreatureFormType::class, $creature);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $creature->setPv($creature->getPvMax())
                ->setPc($creature->getPcMax())
                ->setPm($creature->getPmMax())
                ->setcreatedAt(new DateTimeImmutable());
            $entityManager->persist($creature);
            $entityManager->flush();
            $this->addFlash("success", "La créature a été enregistrée dans le bestiaire.");
            return $this->redirectToRoute("admin_creature_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/liste', name: 'creature_list')]
    public function creatureList(CreatureRepository $CreatureRepository): Response
    {
        $creatures = $CreatureRepository->bestiaryList();
        return $this->render('admin/bestiary/list.html.twig', [
            'creatures' => $creatures
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route('/modifier-creature/{creatureId}', name: 'update_creature')]
    public function updateCreature(
        int $creatureId,
        Request $request,
        EntityManagerInterface $entityManager,
        CreatureRepository $creatureRepository): Response
    {
        $creature = $creatureRepository->find($creatureId);
        $creatureForm = $this->createForm(CreatureFormType::class, $creature);

        $creatureForm->handleRequest($request);
        if ($creatureForm->isSubmitted() && $creatureForm->isValid()) {
            $creature->setPv($creature->getPvMax())
                 ->setPc($creature->getPcMax())
                 ->setPm($creature->getPmMax());
            $entityManager->persist($creature);
            $entityManager->flush();
            $this->addFlash("success", "La créature a été modifiée avec succès.");
            return $this->redirectToRoute("admin_creature_list");
        }
        return $this->render('admin/bestiary/form.html.twig', [
            "creatureForm" => $creatureForm->createView()
        ]);
    }

    /**
     * 
     */
    #[Route('/supprimer-creature/{creatureId}', name: 'delete_creature')]
    public function deleteCreature(
        int $creatureId,
        EntityManagerInterface $entityManager,
        CreatureRepository $creatureRepository)
    {
        $creature = $creatureRepository->find($creatureId);
            $entityManager->remove($creature);
            $entityManager->flush();
            return $this->json("Supprimé avec succès");
    }

    /**
     * permet d'ajouter un nouveau type de bete dans la base de donné (table type_bestiaire)
     * affiche toute les instance se trouvant dans cette table
     */
    #[Route("/liste-type-bestiaire", name:"creature_type_list")]
    public function addCreatureType(
        Request $request,
        EntityManagerInterface $entityManager,
        CreatureTypeRepository $creatureTypeRepository): Response
    {
        $newType = new CreatureType();

        $findall = $creatureTypeRepository->findBy([], ["name" => "ASC"]);
        $form = $this->createForm(NameFormType::class, $newType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newType);
            $entityManager->flush();
            $this->addFlash("success", "Le type ".$newType->getName()."a été enregistré.");
            return $this->redirectToRoute('admin_creature_type_list');
        }
        return $this->render('admin/bestiary/typeList.html.twig', [
            'list' => $findall,
            'form' => $form->createView(),
        ]);
    }
    #[Route("/modifier-type-bestiaire/{typeId}", name:"creature_type_rename")]
    public function teamRename(
        int $typeId,
        Request $request,
        EntityManagerInterface $entityManager,
        CreatureTypeRepository $creatureTypeRepository): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3 || strlen($newName) > 50 ) {
                $this->addFlash("error", "Le nom entré n'est pas valide, il doit faire entre 3 et 50 caractères.");
                return $this->redirectToRoute("admin_creature_type_list");
            }
            $type = $creatureTypeRepository->find($typeId);
            $oldname = $type->getName();
            $type->setName($newName);
            $entityManager->persist($type);
            $entityManager->flush();
            $this->addFlash("success", "Le type ".$oldname." a été renommé ".$newName.".");
        }
        return $this->redirectToRoute("admin_creature_type_list");
    }
}
