<?php

namespace App\Controller\Character;

use Cocur\Slugify\Slugify;
use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\Weapon;
use App\Entity\WeaponCharacter;
use App\Form\CharacterType;
use App\Repository\ArmorPieceRepository;
use App\Repository\CharacterRepository;
use App\Repository\SheetRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
     *
     * @param CharacterRepository $characterRepository
     * @return Response
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
     *
     * @param Request $request
     * @param CharacterRepository $characterRepository
     * @param SheetRepository $sheetRepository
     * @return void
     */
    #[Route('/update', name: 'update_statut')]
    public function updateStatut(Request $request, CharacterRepository $characterRepository, SheetRepository $sheetRepository)
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
    #[Route('/delete/{id}', name:'delete')]
    public function delete(int $id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $character = $doctrine->getRepository(Character::class)->find($id);

        if ($character && $character->getUser() === $this->getUser()) {
            $this->removeFile($character->getImage());
            $entityManager->remove($character);
            $entityManager->flush();
            $this->addFlash("success", "Au revoir ".$character->getName()."! nous vous souhaiton bon vent!");
        }

        return $this->redirectToRoute("character_list");

    }
    /**
     * permet d'afficher et d'editer la fiche de personnage que l'on souhaite
     *
     * @param integer $id
     * @param SkillRepository $skillRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}', name: 'view')]
    public function fichePerso(string $slug, int $id, SkillRepository $skillRepository, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());
        $armor = $doctrine->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
        $weapons = $doctrine->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);
        
        return $this->render('character/character/characterSheet.html.twig', [
            'character' => $character,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons,
        ]);
    }

    #[Route('/{slug}/{id}/option', name:'setting')]
    public function setting(string $slug, int $id, ManagerRegistry $doctrine)
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        return $this->render('character/character/setting.html.twig', ['character' => $character]);
    }
    #[Route("/{slug}/{id}/update", name: "update")]
    public function updateCharact(string $slug, int $id, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Request $request)
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
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
            $slugify = new Slugify();
            $slug = $slugify->slugify($character->getName());
            $character->setSlug($slug);
            $entityManager->persist($character);
            $entityManager->flush();
            $this->addFlash("success", "Les modification de ton personnage ont été sauvegarder");
            return $this->redirectToRoute("character_view", ["slug" => $slug, "id" => $id]);
        }
        return $this->render("character/character/updateCharacter.html.twig", [
            "characterForm" => $characterForm->createView()
        ]);
    }
    /**
     * permet d'editer le champ lore du personnage passer en id 
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}/lore', name: 'update_lore')]
    public function Updatelore(string $slug, int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
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
            $this->addFlash("success", "très intéréssant! nous somme ravi d'en savoir plus sur vous ".$character->getName().".");
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
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}/level-up', name: 'level_up')]
    public function levulUp(string $slug,int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $message = "tes nouvelle statistique ont été enregistrée";
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
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
                $message = "fellicitation ! vous etes desormais niveau ".$character->getLevel();
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
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}/image', name: 'change_image')]
    public function modifImage(string $slug,int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
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
                        //'maxSize' => '50k'
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
                $this->addFlash("success", "c'est toujours agreable de mettre un visage sur un nom! ");
            }
            return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/changeImage.html.twig', [
            "imageForm" => $imageForm->createView(),
            "character" => $character
        ]);
    }

    #[Route("/{slug}/{id}/image/delete", name:'delete_image')]
    public function deleteImage(string $slug,int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $oldImage = $character->getImage();
        if ($oldImage != null) {
            $this->removeFile($oldImage);
            $character->setImage(null);
            $entityManager->persist($character);
            $entityManager->flush();
            $this->addFlash("success", "c'est donc ça un sans visage ?");
        }
        return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
    }

    /**
     * permet de creer un formulaire servant a modifier l'equipement d'un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ArmorPieceRepository $armorPieceRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}/armure', name: 'update_armor')]
    public function updateArmor(string $slug,int $id, Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $armorPieceRepository, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        $locations = $doctrine->getRepository(ArmorLocation::class)->findAll();
        // dd($locations);
        // recherche des toute les piece d'armure appartenent au personnage (dans la table armor_piece_character)
        $armor = $doctrine->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
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
            $name = strtolower($location->getName());
            $str = 'effet_' . $name;

            //ajout d'un Select avec en option les piece d'armure apartenent a la localisation $i
            $armorForm->add($name, EntityType::class, [
                'class' => ArmorPiece::class,
                'choice_label' => 'type.name',
                'query_builder' => $armorPieceRepository->optionType($location->getId()),
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
                $name = strtolower($location->getName());
                $piece = $armorForm->get($name)->getData();
                $effect = $armorForm->get('effet_' . $name)->getData();
                $armor[$location->getId() - 1]->setPiece($piece);
                $armor[$location->getId() - 1]->setEffect($effect);

                $entityManager->persist($armor[$location->getId()  - 1]);
                $entityManager->flush();
                $this->addFlash("success", "vous voila equiper et prêt au combat");
            }
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
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/{slug}/{id}/arme', name: 'update_weapon')]
    public function updateWeapon(string $slug,int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $character = $doctrine->getRepository(Character::class)->findOneBy(["slug"=> $slug, "id" => $id]);
        if (!$character || $character->getUser() !== $this->getUser()) {
            return $this->redirectToRoute("character_list");
        }
        // recherche des toute les armes appartenent au personnage (dans la table arme_personnage)
        $weapons = $doctrine->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);
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
                'choice_label' => 'name',
                'data' => $weapons[$i - 1]->getWeapon(),
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
                $this->addFlash("success", "vous voilà equiper pour pourfandre vos ennemis");
                return $this->redirectToRoute('character_view', ["slug" => $slug, "id" => $id]);
        }
        return $this->render('character/character/weaponForm.html.twig', [
            'weaponForm' => $weaponForm->createView(),
            "character" => $character,
        ]);
    }

    /**
     *  cette fonctrion permet de suprimmer l'encienne image de profil d'un personnage lorsque l'utilisateur la change
     *
     * @param string $file
     * @return void
     */
    public function removeFile(string $file)
    {
        $file_path = $this->getParameter('images_directory') . '/' . $file;
        if (file_exists($file_path)) unlink($file_path);
    }
}
