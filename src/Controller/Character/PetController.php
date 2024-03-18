<?php

namespace App\Controller\Character;

use App\Entity\Pet;
use App\Form\PetType;
use DateTimeImmutable;
use App\Repository\PetRepository;
use App\Repository\TalentRepository;
use App\Repository\StatisticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/familier', name: 'pet_')]
class PetController extends AbstractController
{
    #[Route('/liste', name: 'list')]
    public function list(
        PetRepository $petRepository
    )
    {
        $user = $this->getUser();
        $pets = $petRepository->listByUser($user->getId());
        return $this->render('character/pet/list.html.twig', [
            "pets" => $pets
        ]);
    }

    #[Route('/creation', name: 'create')]
    public function index(
        Request $request,
        SluggerInterface $slugger,
        EntityManagerInterface $entityManager,

    ): Response
    {
        $pet = new Pet();

        $petForm = $this->createForm(PetType::class, $pet);

        $petForm->handleRequest($request);
        if ($petForm->isSubmitted()) {
            // hydratation des champs
            $slug = $slugger->slug($pet->getName());
            $species = $pet->getSpecies();
            $pet
            ->setPv($pet->getPvMax())
            ->setPm($pet->getPmMax())
            ->setPc($pet->getPcMax())

            ->setTalents($species->getTalents())
            ->setLevel($species->getLevel())

            ->setUser($this->getUser())
            ->setSlug($slug)
            ->setcreatedAt(new DateTimeImmutable());
            $entityManager->persist($pet);
            $entityManager->flush();

            $this->addFlash('success', 'Bonjour '.$pet->getName().'!');
            return $this->redirectToRoute('pet_sheet', ["id" => $pet->getId(), "slug" => $pet->getSlug()]);

        }
        return $this->render('character/pet/index.html.twig', [
            'petForm' => $petForm,
        ]);
    }

    #[Route('/{slug}/{id}', name: 'sheet')]
    public function fiche(
        int $id,
        string $slug,
        EntityManagerInterface $entityManager,
        PetRepository $petRepository,
        StatisticRepository $statisticRepository,
        TalentRepository $talentRepository


    ): Response
    {
        $pet = $petRepository->findOneBy(["slug"=> $slug, "id" => $id]);

        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("pet_list");
        }

        $statistics = $statisticRepository->findAllNames();
        $talents = $talentRepository->findAllNames();

        return $this->render('character/pet/sheet.html.twig', [
            'pet' => $pet,
            // 'skills' => $skills,
            // 'armor' => $armor,
            // 'weapons' => $weapons,
            'statistics' => $statistics,
            'talents' => $talents,
            
        ]);
    }

    #[Route('/{slug}/{id}/modifier', name: 'update')]
    public function update(
        int $id,
        string $slug,
        EntityManagerInterface $entityManager,
        PetRepository $petRepository,
        Request $request,
        SluggerInterface $slugger

    ): Response
    {
        $pet = $petRepository->findOneBy(["slug"=> $slug, "id" => $id]);

        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("pet_list");
        }

        $petForm = $this->createForm(PetType::class, $pet);
        $petForm->remove("pvMax")
        ->remove("pcMax")
        ->remove("pmMax")
        ->remove("level")
        ->remove("constitution")
        ->remove("strength")
        ->remove("dexterity")
        ->remove("intelligence")
        ->remove("charisma")
        ->remove("faith");

        $petForm->handleRequest($request);
        if ($petForm->isSubmitted() && $petForm->isValid()) {
            $slug = $slugger->slug($pet->getName());
            $pet->setSlug($slug);
            $entityManager->persist($pet);
            $entityManager->flush();
            $this->addFlash("success", "Les modifications de ton familier ont été enregistré.");
            return $this->redirectToRoute("pet_sheet", ["slug" => $slug, "id" => $id]);
        }

        return $this->render('character/pet/update.html.twig', [
            'petForm' => $petForm,
            
        ]);
    }

    #[Route('/{slug}/{id}/statistiques', name: 'level_up')]
    public function levulUp(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        PetRepository $petRepository): Response
    {
        $message = "Vos nouvelles statistiques ont été enregistrées.";
        // $pet = $petRepository->find($id);
        $pet = $petRepository->findOneBy(["slug"=> $slug, "id" => $id]);

        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("pet_list");
        }

        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("pet_list");
        }

        $currentLevel = $pet->getLevel();
        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $petForm = $this->createForm(PetType::class, $pet);

        //annulation affichage champs hors formulaire
        $petForm->remove('name');
        $petForm->remove('owner');
        $petForm->remove('species');

        $petForm->handleRequest($request);
        if ($petForm->isSubmitted() && $petForm->isValid()) {
            // hydratation des champs
            $pet->setPv($pet->getPvMax());
            $pet->setPm($pet->getPmMax());
            $pet->setPc($pet->getPcMax());
            //
            // execution de la requete
            $entityManager->persist($pet);
            $entityManager->flush();
            //
            if ($pet->getLevel() > $currentLevel) {
                $message = "Félicitations ! Vous êtes désormais au niveau ".$pet->getLevel().".";
            }
            $this->addFlash('success', $message);
            return $this->redirectToRoute('pet_sheet', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/pet/levelupForm.html.twig', [
            "petForm" => $petForm->createView(),
            "pet" => $pet,
        ]);
    }

    #[Route('/{slug}/{id}/lore', name: 'update_lore')]
    public function Updatelore(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        PetRepository $petRepository)
    {
        $pet = $petRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $loreForm = $this->createFormBuilder($pet)
            ->add('lore', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'area-form ckeditor']
            ])
            ->getForm();
        $loreForm->handleRequest($request);
        if ($loreForm->isSubmitted() && $loreForm->isValid()) {

            // execution de la requete
            $entityManager->persist($pet);
            $entityManager->flush();
            //
            $this->addFlash("success", "Très intéressant ! Nous sommes ravis d'en savoir plus sur vous ".$pet->getName().".");
            return $this->redirectToRoute('pet_sheet', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/loreForm.html.twig', [
            "loreForm" => $loreForm->createView(),
            "pet" =>$pet,
        ]);
    }

    #[Route('/{slug}/{id}/talents', name: 'update_talent')]
    public function updateTalent(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        PetRepository $petRepository,
        TalentRepository $talentRepository)
    {
        $pet = $petRepository->findOneBy(["slug"=> $slug, "id" => $id]);

        if (!$pet || $pet->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("pet_list");
        }


        $petTalentsId = [];
        $equipedTalents = json_encode($pet->getTalents());

        if ($pet->getTalents() ==! null) {
            foreach ($pet->getTalents() as $key => $talent) {
                array_push($petTalentsId, $key);
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
                $pet->setTalents($equipedTalents);
                $entityManagerInterface->persist($pet);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('pet_sheet', ["slug" => $pet->getSlug(), "id" => $pet->getId()]);
            }
            else {
                foreach ($errors as $error) {
                    $this->addFlash("error",$error);
                }
                $equipedTalents = json_encode($equipedTalents);
            }
        }

 
        
        return $this->render('character/character/talentsForm.html.twig', [
            "character" => $pet,
            "equipedTalentsIds" => $petTalentsId,
            "equipedTalents" => $equipedTalents,
            "talents" => $talents,
        ]);
    }
}
