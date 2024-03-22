<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Creature;
use App\Form\NameFormType;
use App\Entity\CreatureType;
use App\Form\CreatureFormType;
use App\Repository\TalentRepository;
use App\Repository\CreatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CreatureTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/administration/bestiaire', name: 'admin_')]
class CreatureController extends AbstractController
{
     /**
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

    #[Route('/{creatureId}/talents', name: 'creature_update_talent')]
    public function updateTalent(
        // string $slug,
        int $creatureId,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        CreatureRepository $creatureRepository,
        TalentRepository $talentRepository)
    {
        $creature = $creatureRepository->find($creatureId);
        // $creature = $creatureRepository->findOneBy(["slug"=> $slug, "id" => $id]);

        $creatureTalentsId = [];
        $equipedTalents = json_encode($creature->getTalents());

        if ($creature->getTalents() ==! null) {
            foreach ($creature->getTalents() as $key => $talent) {
                array_push($creatureTalentsId, $key);
            }
        }

        $talents = $talentRepository->findAllNames();
        if ($request->isMethod("post")) {
            $errors = [];
            $equipedTalents = json_decode($request->request->get("talents"), true);
            foreach ($equipedTalents as $key => $talent) {

                $indexOfTalent = array_search($key, array_column($talents, 'id'));
                if ($indexOfTalent === false) {
                    if (isset($talent['name']) === false) {
                        $this->addFlash("error", "le talent " .$talent['name']. " n'a pas été trouvé ou n'existe plus");
                    }
                    else {
                        unset($equipedTalents[$key]);
                    }
                }
                else {
                    $equipedTalents[$key]['name'] = $talents[$indexOfTalent]['name'];
                    $equipedTalents[$key]['statistic'] = $talents[$indexOfTalent]['statistic_id'];
                    if ($talent['level'] <0 || $talent['level']>3) {
                        array_push($errors,'erreur le talent ' .$equipedTalents[$key]['name']. " a un niveau non conforme");
                    }
                    if ($talent['otherBonus'] <0) {
                        array_push($errors,'erreur le talent ' .$equipedTalents[$key]['name']. " a un bonus non conforme");
                    }
                }
            }
            if (count($errors) === 0) {
                $creature->setTalents($equipedTalents);
                $entityManagerInterface->persist($creature);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('admin_creature_list');
            }
            else {
                foreach ($errors as $error) {
                    $this->addFlash("error",$error);
                }
                $equipedTalents = json_encode($equipedTalents);
            }
        }

 
        
        return $this->render('admin/bestiary/talentsForm.html.twig', [
            "character" => $creature,
            "equipedTalentsIds" => $creatureTalentsId,
            "equipedTalents" => $equipedTalents,
            "talents" => $talents,
        ]);
    }
}
