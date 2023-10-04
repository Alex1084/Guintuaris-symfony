<?php

namespace App\Controller\Character;

use App\Entity\ArmorPiece;
use App\Entity\ArmorPieceCharacter;
use App\Entity\Weapon;
use App\Entity\WeaponCharacter;
use App\Form\CharacterType;
use App\Repository\ArmorLocationRepository;
use App\Repository\ArmorPieceCharacterRepository;
use App\Repository\ArmorPieceRepository;
use App\Repository\CharacterRepository;
use App\Repository\SheetRepository;
use App\Repository\SkillRepository;
use App\Repository\StatisticRepository;
use App\Repository\TalentRepository;
use App\Repository\WeaponCharacterRepository;
use App\Repository\WeaponRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/personnage', name: 'character_')]
class CharacterController extends AbstractController
{
    #[Route('/list', name: 'list')]
    /**
     * affiche la liste des personnage qui appartienent au joueur connecter
     * chaque nom des personnage rammene ver leur fiche
     */
    public function list(CharacterRepository $characterRepository): Response
    {
        $user = $this->getUser();
        $characters = $characterRepository->listByUser($user->getId());
        return $this->render('character/character/list.html.twig', [
            "characters" => $characters
        ]);
    }

    /**
     * Undocumented function
     */
    #[Route('/modifier-statut', name: 'update_statut')]
    public function updateStatut(
        Request $request,
        CharacterRepository $characterRepository,
        SheetRepository $sheetRepository)
    {
        if ($request->isMethod('post')) {
            $data = json_decode($request->getContent());
            $characterRepository->updateInventaire($data->id, $data->inventaire, $data->po);
            $sheetRepository->updateStatus($data->id, $data->pv, $data->pc, $data->pm);
            
            return $this->json(
                "result", 200
            );
        }
        else{
            return $this->json('error', 401);
        }
    }
    #[Route('/supprimer/{id}', name:'delete')]
    public function delete(
        int $id,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository,
        )
    {
        $character = $characterRepository->find($id);

        if ($character && $character->getUser() === $this->getUser()) {
            $this->removeFile($character->getImage());
            $entityManager->remove($character);
            $entityManager->flush();
            $this->addFlash("success", "Au revoir ".$character->getName()." ! Nous vous souhaitons bon vent !");
        }

        return $this->redirectToRoute("character_list");

    }
    /**
     * permet d'afficher et d'editer la fiche de personnage que l'on souhaite
     */
    #[Route('/{slug}/{id}', name: 'view')]
    public function fichePerso(
        string $slug,
        int $id,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository,
        SkillRepository $skillRepository,
        ArmorPieceCharacterRepository $armorPieceCharacterRepository,
        WeaponCharacterRepository $weaponCharacterRepository,
        StatisticRepository $statisticRepository,
        TalentRepository $talentRepository): Response
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());
        // todo : create custom query
        $armor = $armorPieceCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "asc"]);
        $weapons = $weaponCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "asc"]);
        
        $statistics = $statisticRepository->findAllNames();
        $talents = $talentRepository->findAllNames();

        $character->setLastView(new DateTimeImmutable());
        $entityManager->persist($character);
        $entityManager->flush();
        
        return $this->render('character/character/characterSheet.html.twig', [
            'character' => $character,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons,
            'statistics' => $statistics,
            'talents' => $talents,
            
        ]);
    }

    #[Route('/{slug}/{id}/option', name:'setting')]
    public function setting(
        string $slug,
        int $id,
        CharacterRepository $characterRepository)
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        return $this->render('character/character/setting.html.twig', ['character' => $character]);
    }

    #[Route("/{slug}/{id}/modifier", name: "update")]
    public function updateCharact(
        string $slug,
        int $id,
        EntityManagerInterface $entityManager,
        Request $request,
        SluggerInterface $slugger,
        CharacterRepository $characterRepository)
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }

        $characterForm = $this->createForm(CharacterType::class, $character);
        $characterForm->remove("pvMax")
                    ->remove("pcMax")
                    ->remove("pmMax")
                    ->remove("level")
                    ->remove("constitution")
                    ->remove("strength")
                    ->remove("dexterity")
                    ->remove("intelligence")
                    ->remove("charisma")
                    ->remove("faith");
        $characterForm->handleRequest($request);
        if ($characterForm->isSubmitted() && $characterForm->isValid()) {
            $slug = $slugger->slug($character->getName());
            $character->setSlug($slug);
            $entityManager->persist($character);
            $entityManager->flush();
            $this->addFlash("success", "Les modifications de ton personnage ont été sauvegardées.");
            return $this->redirectToRoute("character_view", ["slug" => $slug, "id" => $id]);
        }
        return $this->render("character/character/updateCharacter.html.twig", [
            "characterForm" => $characterForm->createView()
        ]);
    }
    /**
     * permet d'editer le champ lore du personnage passer en id 
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     */
    #[Route('/{slug}/{id}/lore', name: 'update_lore')]
    public function Updatelore(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository): Response
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $loreForm = $this->createFormBuilder($character)
            ->add('lore', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'area-form']
            ])
            ->getForm();
        $loreForm->handleRequest($request);
        if ($loreForm->isSubmitted() && $loreForm->isValid()) {

            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();
            //
            $this->addFlash("success", "Très intéressant ! Nous sommes ravis d'en savoir plus sur vous ".$character->getName().".");
            return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/loreForm.html.twig', [
            "loreForm" => $loreForm->createView(),
            "character" =>$character,
        ]);
    }

    /**
     * permet d'editer les statistique du personnage, son statut au max et son niveau
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     */
    #[Route('/{slug}/{id}/statistiques', name: 'level_up')]
    public function levulUp(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository): Response
    {
        $message = "Vos nouvelles statistiques ont été enregistrées.";
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        $currentLevel = $character->getLevel();
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $characterForm = $this->createForm(CharacterType::class, $character);

        //annulation affichage champs hors formulaire
        $characterForm->remove('name');
        $characterForm->remove('class');
        $characterForm->remove('race');

        $characterForm->handleRequest($request);
        if ($characterForm->isSubmitted() && $characterForm->isValid()) {
            // hydratation des champs
            $character->setPv($character->getPvMax());
            $character->setPm($character->getPmMax());
            $character->setPc($character->getPcMax());
            //
            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();
            //
            if ($character->getLevel() > $currentLevel) {
                $message = "Félicitations ! Vous êtes désormais au niveau ".$character->getLevel().".";
            }
            $this->addFlash('success', $message);
            return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/levelupForm.html.twig', [
            "characterForm" => $characterForm->createView(),
            "character" => $character,
        ]);
    }

    /**
     * permet d'editer la photo de "profil" du personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     */
    #[Route('/{slug}/{id}/image', name: 'change_image')]
    public function modifImage(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository): Response
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $imageForm = $this->createFormBuilder()
            ->add('image', FileType::class, [
                'label' => 'image (jpg)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '50k',
                        'mimeTypes' => 'image/jpg',
                    ])
                ]
            ])
            ->getForm();
        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $oldImage = $character->getImage();
            $newImage = $imageForm->get('image')->getData();

            if ($oldImage != null) {
                $this->removeFile($oldImage);
            }
            if ($newImage) {
                $fileName = md5(uniqid()) . '.' . $newImage->guessExtension();
                $newImage->move($this->getParameter('images_directory'), $fileName);
                $character->setImage($fileName);
                $entityManager->persist($character);
                $entityManager->flush();
                $this->addFlash("success", "C'est toujours agréable de mettre un visage sur un nom !");
            }
            return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/changeImage.html.twig', [
            "imageForm" => $imageForm->createView(),
            "character" => $character
        ]);
    }

    #[Route("/{slug}/{id}/image/supprimer", name:'delete_image')]
    public function deleteImage(
        string $slug,
        int $id,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository)
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $oldImage = $character->getImage();
        if ($oldImage != null) {
            $this->removeFile($oldImage);
            $character->setImage(null);
            $entityManager->persist($character);
            $entityManager->flush();
            $this->addFlash("success", "C'est donc ça un sans visage ?");
        }
        return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
    }

    /**
     * permet de creer un formulaire servant a modifier l'equipement d'un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     */
    #[Route('/{slug}/{id}/armure', name: 'update_armor')]
    public function updateArmor(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        ArmorPieceRepository $armorPieceRepository,
        CharacterRepository $characterRepository,
        ArmorLocationRepository $armorLocationRepository,
        ArmorPieceCharacterRepository $armorPieceCharacterRepository): Response
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $locations = $armorLocationRepository->findBy([], ["id" => "ASC"]);
        // dd($locations);
        // recherche des toute les piece d'armure appartenent au personnage (dans la table armor_piece_character)
        $armor = $armorPieceCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "asc"]);
        if (count($armor) < count($locations)) {
            $ids = array_map(function ($armorPieceCharacter)
            {
                return $armorPieceCharacter->getId();
            }, $armor);
            foreach ($locations as $location) {
                $index = array_search($location->getId(), $ids);
                if ($index === false) {
                    $piece = new ArmorPieceCharacter();
                    $piece->setId($location->getId())
                    ->setCharact($character);
                    array_push($armor, $piece);
                }
            }
        }
        $armorForm = $this->createFormBuilder();

        //ajout des champs dans le formulmaire
        foreach ($locations as $location) {
            $name = $location->getVarName();
            $str = 'effet_' . $name;

            //ajout d'un Select avec en option les piece d'armure apartenent a la localisation $i
            $armorForm->add($name, EntityType::class, [
                'class' => ArmorPiece::class,
                'query_builder' => function (ArmorPieceRepository $apr) {
                    return $apr->createQueryBuilder('ap')
                        ->orderBy('ap.name', 'ASC');
                },
                "label" => $location->getName(),
                'choice_label' => 'type.name',
                'query_builder' => $armorPieceRepository->optionType($location->getId()),
                'preferred_choices' => $armorPieceRepository->findEmptybyLocation($location->getId()),
                'data' => $armor[$location->getId() - 1]->getPiece(),
                'attr' => ['class' => 'input-form']
            ])
            //ajout d'un champs string pour metre l'effet de la piece d'armure
            ->add($str, TextType::class, [
                'required' => false,
                'data' => $armor[$location->getId() - 1]->getEffect(),
                'label' => 'Effet',
                'attr' => ['class' => 'input-form'],
                'constraints' => [
                    new Length([
                        "min" => 5,
                        "max" => 50,
                        "maxMessage" =>  "le nom doit faire 50 caractère maximum",
                        "minMessage" =>  "le nom doit faire 5 caractère minimum"
                    ]),
                ]
            ]);
        }

        $armorForm = $armorForm->getForm();
        $armorForm->handleRequest($request);
        if ($armorForm->isSubmitted() && $armorForm->isValid()) {

            //cette boucle permet de recuperer toute les donnée envoyer et de mettre a jour la base de donnée
            foreach ($locations as $location) {
                $name = $location->getVarName();
                $piece = $armorForm->get($name)->getData();
                $effect = $armorForm->get('effet_' . $name)->getData();
                $armor[$location->getId() - 1]->setPiece($piece);
                $armor[$location->getId() - 1]->setEffect($effect);

                $entityManager->persist($armor[$location->getId()  - 1]);
                $entityManager->flush();
            }
            $this->addFlash("success", "Vous voilà équipé et prêt au combat.");
            return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/armorForm.html.twig', [
            "armorForm" => $armorForm->createView(),
            "character" => $character,
            "locations" => $locations
        ]);
    }

    /**
     * permet de modifier les arme equiper par un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     */
    #[Route('/{slug}/{id}/arme', name: 'update_weapon')]
    public function updateWeapon(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository,
        WeaponRepository $weaponRepository,
        WeaponCharacterRepository $weaponCharacterRepository): Response
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        // recherche des toute les armes appartenent au personnage (dans la table arme_personnage)
        $weapons = $weaponCharacterRepository->findBy(["charact" => $character->getId()], ["id" => "asc"]);
        if (count($weapons) <= 3) {
            $ids = array_map(function ($weaponCharacter)
            {
                return $weaponCharacter->getId();
            }, $weapons);
            for ($i=1; $i <= 3; $i++)  {
                $index = array_search($i, $ids);
                if ($index === false) {
                    $weapon= new WeaponCharacter();
                    $weapon->setId($i)
                    ->setCharact($character);
                    array_push($weapons, $weapon);
                }
            }
        }
        $weaponForm = $this->createFormBuilder();
        
        //ajout des champs dans le formulmaire
        for ($i = 1; $i <= 3; $i++) {
            $str = 'effet_' . $i;
            //ajout d'un champs select ayant comme identifiant un numero allant de 1 a 3
            // et ayant comme option la liste de toute les armes
            $weaponForm->add('n_' . $i, EntityType::class, [
                'class' => Weapon::class,
                'query_builder' => $weaponRepository->optionType(),
                'choice_label' => 'name',
                'data' => $weapons[$i - 1]->getWeapon(),
                'preferred_choices' => $weaponRepository->findEmpty(),
                'attr' => ['class' => 'input-form'],
                'label' => 'Arme N°' . $i
            ])
                //ajout d'un champs String pour metre l'enchetement de l'arme 
                ->add($str, TextType::class, [
                    'required' => false,
                    'data' => $weapons[$i - 1]->getEffect(),
                    'label' => 'Effet',
                    'attr' => ['class' => 'input-form'],
                    'constraints' => [
                        new Length([
                            "min" => 5,
                            "max" => 50,
                            "maxMessage" =>  "le nom doit faire 50 caractère maximum",
                            "minMessage" =>  "le nom doit faire 5 caractère minimum"
                        ]),
                    ]
                ]);
        }
        $weaponForm = $weaponForm->getForm();
        $weaponForm->handleRequest($request);
        if ($weaponForm->isSubmitted() && $weaponForm->isValid()) {

            //cette boucle permet de recuperer toute les donnée envoyer et de mettre a jour la base de donnée
            for ($i = 1; $i <= 3; $i++) {
                $weapon = $weaponForm->get('n_' . $i)->getData();
                $effect = $weaponForm->get('effet_' . $i)->getData();
                $weapons[$i - 1]->setWeapon($weapon);
                $weapons[$i - 1]->setEffect($effect);

                $entityManager->persist($weapons[$i - 1]);
                $entityManager->flush();
            }
                $this->addFlash("success", "Vous voilà équipé pour pourfendre vos ennemis.");
                return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/weaponForm.html.twig', [
            'weaponForm' => $weaponForm->createView(),
            "character" => $character,
        ]);
    }

    #[Route('/{slug}/{id}/talents', name: 'update_talent')]
    public function updateTalent(
        string $slug,
        int $id,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        CharacterRepository $characterRepository,
        TalentRepository $talentRepository)
    {
        $character = $characterRepository->findOneBy(["slug"=> $slug, "id" => $id]);
        $characterTalentsId = [];
        $equipedTalents = json_encode($character->getTalents());

        if ($character->getTalents() ==! null) {
            foreach ($character->getTalents() as $key => $talent) {
                array_push($characterTalentsId, $key);
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
                $character->setTalents($equipedTalents);
                $entityManagerInterface->persist($character);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('character_view', ["slug" => $character->getSlug(), "id" => $character->getId()]);
            }
            else {
                foreach ($errors as $error) {
                    $this->addFlash("error",$error);
                }
                $equipedTalents = json_encode($equipedTalents);
            }
        }

 
        
        return $this->render('character/character/talentsForm.html.twig', [
            "character" => $character,
            "equipedTalentsIds" => $characterTalentsId,
            "equipedTalents" => $equipedTalents,
            "talents" => $talents,
        ]);
    }
    /**
     *  cette fonctrion permet de suprimmer l'encienne image de profil d'un personnage lorsque l'utilisateur la change
     */
    public function removeFile(string $file)
    {
        $file_path = $this->getParameter('images_directory') . '/' . $file;
        if (file_exists($file_path)) unlink($file_path);
    }
}
