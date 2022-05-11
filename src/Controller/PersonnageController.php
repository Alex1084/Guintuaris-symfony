<?php

namespace App\Controller;

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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;

/**
 * voici le plus gros controller il permet de gerer tout ce qui est lié de près au personnage
 * chacun des controller son lié au joueur qui possede le personnage 
 * donc toute les page ayant un id dans l'url ne doivent pas etre accessible par un joueur qui ne possede pas un personnage 
 * 
 * @Route("/personnage", name="character_")
 */
class PersonnageController extends AbstractController
{

    /**
     * affiche la liste des personnage qui appartienent au joueur connecter
     * chaque nom des personnage rammene ver leur fiche
     * 
     * @Route("/list", name="list")
     *
     */
    public function list(CharacterRepository $characterRepository): Response
    {
        $user = $this->getUser();
        $characters = $characterRepository->listByUser($user->getId());
        return $this->render('personnage/list.html.twig', [
            "characters" => $characters
        ]);
    }

    /**
     * Undocumented function
     *
     * @Route("/update", name="update_statut")
     */
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
    /**
     * permet d'afficher et d'editer la fiche de personnage que l'on souhaite
     * 
     * @Route("/{id}", name="view")
     *
     */
    public function fichePerso(int $id, SkillRepository $skillRepository): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->find($id);
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());
        $armor = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);
        $weapons = $this->getDoctrine()->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);
        
        return $this->render('personnage/fichePersonnage.html.twig', [
            'character' => $character,
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons,
        ]);
    }

    /**
     * permet d'editer le champ lore du personnage passer en id 
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     * 
     * @Route("/{id}/lore", name="update_lore")
     *
     */
    public function Updatelore(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Character::class);
        $character = $repo->find($id);
        $loreForm = $this->createFormBuilder($character)
            ->add('lore', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'area-form']
            ])
            ->getForm();
        $loreForm->handleRequest($request);
        if ($loreForm->isSubmitted()) {

            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();
            //
            return $this->redirectToRoute('character_view', ["id" => $id]);
        }
        return $this->render('personnage/lore.html.twig', [
            "loreForm" => $loreForm->createView(),
            "character" =>$character,
        ]);
    }

    /**
     * permet d'editer les statistique du personnage, son statut au max et son niveau
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     * 
     * @Route("/{id}/level-up", name="level_up")
     *
     */
    public function levulUp(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $character = $this->getDoctrine()->getRepository(Character::class)->find($id);
        $characterForm = $this->createForm(CharacterType::class, $character);

        //annulation affichage champs hors formulaire
        $characterForm->remove('name');
        $characterForm->remove('class');
        $characterForm->remove('race');

        $characterForm->handleRequest($request);
        if ($characterForm->isSubmitted()) {
            // hydratation des champs 
            $character->setPv($character->getPvMax());
            $character->setPm($character->getPmMax());
            $character->setPc($character->getPcMax());
            //
            // execution de la requete
            $entityManager->persist($character);
            $entityManager->flush();
            //

            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('character_view', ["id" => $id]);
        }
        return $this->render('personnage/levelup.html.twig', [
            "characterForm" => $characterForm->createView(),
            "character" => $character,
        ]);
    }

    /**
     * permet d'editer la photo de "profil" du personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     * 
     * @Route("/{id}/image", name="change_image")
     *
     */
    public function modifImage(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->find($id);
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
        if ($imageForm->isSubmitted()) {
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
            }
            return $this->redirectToRoute('character_view', ["id" => $id]);
        }
        return $this->render('personnage/changeImage.html.twig', [
            "imageForm" => $imageForm->createView(),
            "character" => $character
        ]);
    }

    /**
     * permet de creer un formulaire servant a modifier l'equipement d'un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     * 
     * @Route("/{id}/armure", name="update_armor")
     *
     */
    public function updateArmor(int $id, Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $armorPieceRepository): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->find($id);
        // recherche des toute les piece d'armure appartenent au personnage (dans la table armor_piece_character)
        $armor = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $character->getId()]);

        //ce tableau permet de savoir dans la boucle a quel localisation fais reference un champs 
        $pieces = [1 => 'casque', 'plastron', 'jambiere', 'anneau', 'amulette', 'cape', 'bouclier'];

        $armorForm = $this->createFormBuilder();

        //ajout des champs dans le formulmaire
        for ($i = 1; $i <= 7; $i++) {
            $str = 'effet_' . $pieces[$i];

            //ajout d'un Select avec en option les piece d'armure apartenent a la localisation $i
            $armorForm->add($pieces[$i], EntityType::class, [
                'class' => ArmorPiece::class,
                'choice_label' => 'type.name',
                'query_builder' => $armorPieceRepository->optionType($i),
                'data' => $armor[$i - 1]->getPiece(),
                'attr' => ['class' => 'input-form']
            ])
                //ajout d'un champs string pour metre l'effet de la piece d'armure
                ->add($str, TextType::class, [
                    'required' => false,
                    'data' => $armor[$i - 1]->getEffect(),
                    'label' => 'Effet',
                    'attr' => ['class' => 'input-form']
                ]);
        }

        $armorForm = $armorForm->getForm();
        $armorForm->handleRequest($request);
        if ($armorForm->isSubmitted()) {

            //cette boucle permet de recuperer toute les donnée envoyer et de mettre a jour la base de donnée
            for ($i = 1; $i <= 7; $i++) {
                $piece = $armorForm->get($pieces[$i])->getData();
                $effect = $armorForm->get('effet_' . $pieces[$i])->getData();
                $armor[$i - 1]->setPiece($piece);
                $armor[$i - 1]->setEffect($effect);

                $entityManager->persist($armor[$i - 1]);
                $entityManager->flush();
            }
            return $this->redirectToRoute('character_view', ["id" => $id]);
        }
        return $this->render('personnage/equipement.html.twig', [
            'armorForm' => $armorForm->createView(),
            "character" => $character,
        ]);
    }

    /**
     * permet de modifier les arme equiper par un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers character_view
     * 
     * @Route("/{id}/arme", name="update_weapon")
     *
     */
    public function updateWeapon(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->find($id);

        // recherche des toute les armes appartenent au personnage (dans la table arme_personnage)
        $weapons = $this->getDoctrine()->getRepository(WeaponCharacter::class)->findBy(["charact" => $character->getId()]);

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
                    'attr' => ['class' => 'input-form']
                ]);
        }
        $weaponForm = $weaponForm->getForm();
        $weaponForm->handleRequest($request);
        if ($weaponForm->isSubmitted()) {

            //cette boucle permet de recuperer toute les donnée envoyer et de mettre a jour la base de donnée
            for ($i = 1; $i <= 3; $i++) {
                $weapon = $weaponForm->get('n_' . $i)->getData();
                $effect = $weaponForm->get('effet_' . $i)->getData();
                $weapons[$i - 1]->setWeapon($weapon);
                $weapons[$i - 1]->setEffect($effect);

                $entityManager->persist($weapons[$i - 1]);
                $entityManager->flush();
            }
            return $this->redirectToRoute('character_view', ["id" => $id]);
        }
        return $this->render('personnage/arme.html.twig', [
            'weaponForm' => $weaponForm->createView(),
            "character" => $character,
        ]);
    }

    /**
     * cette fonction a pour but de retouver toute les piece d'armure ayant comme localisation l'identifient placer en parametre
     *
     */


    /**
     *  cette fonctrion permet de suprimmer l'encienne image de profil d'un personnage lorsque l'utilisateur la change
     *
     */
    public function removeFile(string $file)
    {
        $file_path = $this->getParameter('images_directory') . '/' . $file;
        if (file_exists($file_path)) unlink($file_path);
    }
}
