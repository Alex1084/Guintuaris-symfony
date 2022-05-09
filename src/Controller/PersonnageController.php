<?php

namespace App\Controller;

use App\Entity\ArmorPiece;
use App\Entity\ArmorPieceCharacter;
use App\Entity\Personnage;
use App\Entity\Weapon;
use App\Entity\WeaponCharacter;
use App\Form\PersonnageType;
use App\Repository\ArmorPieceRepository;
use App\Repository\CompetenceRepository;
use App\Repository\FicheRepository;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
 * @Route("/personnage", name="personnage_")
 */
class PersonnageController extends AbstractController
{

    /**
     * affiche la liste des personnage qui appartienent au joueur connecter
     * chaque nom des personnage rammene ver leur fiche
     * 
     * @Route("/list", name="list")
     *
     * @return Response
     */
    public function list(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $user = $this->getUser();
        $personnages = $repo->findBy(array('joueur' => $user->getId()), array('nom' => 'ASC'));
        return $this->render('personnage/list.html.twig', [
            "personnages" => $personnages
        ]);
    }

    /**
     * Undocumented function
     *
     * @Route("/update", name="update_statut")
     */
    public function updateStatut(Request $request, PersonnageRepository $personnageRepository, FicheRepository $ficheRepository)
    {
        if ($request->isMethod('post')) {
            $data = json_decode($request->getContent());
            $personnageRepository->updateInventaire($data->id, $data->inventaire, $data->po);
            $ficheRepository->updateStatus($data->id, $data->pv, $data->pc, $data->pm);
            
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
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CompetenceRepository $compRepo
     * @return Response
     */
    public function fichePerso(int $id, Request $request, EntityManagerInterface $entityManager, CompetenceRepository $compRepo): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $competences = $compRepo->findByLevel($personnage->getNiveau(), $personnage->getClasse()->getId());
        $repo = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class);
        $armor = $repo->findBy(["charact" => $personnage->getId()]);
        $repo = $this->getDoctrine()->getRepository(WeaponCharacter::class);
        $weapons = $repo->findBy(["charact" => $personnage->getId()]);
        
        return $this->render('personnage/fichePersonnage.html.twig', [
            'personnage' => $personnage,

            'competences' => $competences,
            'armor' => $armor,
            'weapons' => $weapons,
        ]);
    }

    /**
     * permet d'editer le champ lore du personnage passer en id 
     * une fois le formulaire valider on redirige l'utilisateur vers personnage_view
     * 
     * @Route("/{id}/lore", name="modif_lore")
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function lore(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $loreForm = $this->createFormBuilder($personnage)
            ->add('lore', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'area-form']
            ])
            ->getForm();
        $loreForm->handleRequest($request);
        if ($loreForm->isSubmitted()) {

            // execution de la requete
            $entityManager->persist($personnage);
            $entityManager->flush();
            //
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/lore.html.twig', [
            "loreForm" => $loreForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    /**
     * permet d'editer les statistique du personnage, son statut au max et son niveau
     * une fois le formulaire valider on redirige l'utilisateur vers personnage_view
     * 
     * @Route("/{id}/level_up", name="level_up")
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function levulUp(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $personnageForm = $this->createForm(PersonnageType::class, $personnage);

        //annulation affichage champs hors formulaire
        $personnageForm->remove('nom');
        $personnageForm->remove('lore');
        $personnageForm->remove('inventaire');
        $personnageForm->remove('po');
        $personnageForm->remove('joueur');
        $personnageForm->remove('classe');
        $personnageForm->remove('race');

        $personnageForm->handleRequest($request);
        if ($personnageForm->isSubmitted()) {
            // hydratation des champs 
            $personnage->setPv($personnage->getPvMax());
            $personnage->setPm($personnage->getPmMax());
            $personnage->setPc($personnage->getPcMax());
            //
            // execution de la requete
            $entityManager->persist($personnage);
            $entityManager->flush();
            //

            $this->addFlash('success', 'ton perso a été créer');
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/levelup.html.twig', [
            "personnageForm" => $personnageForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    /**
     * permet d'editer la photo de "profil" du personnage
     * une fois le formulaire valider on redirige l'utilisateur vers personnage_view
     * 
     * @Route("/{id}/image", name="change_image")
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function modifImage(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $personnage = $this->getDoctrine()->getRepository(Personnage::class)->find($id);
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
            $ancienneImage = $personnage->getImage();
            $photo = $imageForm->get('image')->getData();

            if ($ancienneImage != null) {
                $this->removeFile($ancienneImage);
            }
            if ($photo) {
                $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                $photo->move($this->getParameter('images_directory'), $fichier);
                $personnage->setImage($fichier);
                $entityManager->persist($personnage);
                $entityManager->flush();
            }
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/changeImage.html.twig', [
            "imageForm" => $imageForm->createView(),
            "personnage" => $personnage
        ]);
    }

    /**
     * permet de creer un formulaire servant a modifier l'equipement d'un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers personnage_view
     * 
     * @Route("/{id}/armure", name="modif_armure")
     *
     */
    public function updateArmor(int $id, Request $request, EntityManagerInterface $entityManager, ArmorPieceRepository $pr): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        // recherche des toute les piece d'armure appartenent au personnage (dans la table armor_piece_character)
        $armor = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class)->findBy(["charact" => $personnage->getId()]);

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
                'query_builder' => $this->optionType($i, $pr),
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
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/equipement.html.twig', [
            'armorForm' => $armorForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    /**
     * permet de modifier les arme equiper par un personnage
     * une fois le formulaire valider on redirige l'utilisateur vers personnage_view
     * 
     * @Route("/{id}/arme", name="modif_arme")
     *
     * @param integer $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function updateWeapon(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);

        // recherche des toute les armes appartenent au personnage (dans la table arme_personnage)
        $weapons = $this->getDoctrine()->getRepository(WeaponCharacter::class)->findBy(array("charact" => $personnage->getId()));

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
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/arme.html.twig', [
            'weaponForm' => $weaponForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    /**
     * cette fonction a pour but de retouver toute les piece d'armure ayant comme localisation l'identifient placer en parametre
     *
     */
    private function optionType(int $id, ArmorPieceRepository $pr)
    {
        return $pr->createQueryBuilder('p')
            ->where('p.location = :id')
            ->setParameter("id", $id);
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
