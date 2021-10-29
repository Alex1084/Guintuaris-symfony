<?php

namespace App\Controller;

use App\Entity\Arme;
use App\Entity\ArmePersonnage;
use App\Entity\Personnage;
use App\Entity\Equipe;
use App\Entity\PieceArmure;
use App\Entity\PieceArmurePersonnage;
use App\Form\PersonnageType;
use App\Repository\CompetenceRepository;
use App\Repository\PieceArmureRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Filesystem;
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
 * @Route("/personnage", name="personnage_")
 */
class PersonnageController extends AbstractController
{

    /**
     * @Route("/list", name="list")
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
     * @Route("/{id}", name="view")
     */
    public function fichePerso($id, Request $request, EntityManagerInterface $entityManager, CompetenceRepository $compRepo): Response
    {
        //dd($request);
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $competences = $compRepo->findByLevel($personnage->getNiveau(), $personnage->getClasse()->getId());
        $repo = $this->getDoctrine()->getRepository(PieceArmurePersonnage::class);
        $armure = $repo->findBy(array("personnage" => $personnage->getId()));
        $repo = $this->getDoctrine()->getRepository(ArmePersonnage::class);
        $armes = $repo->findBy(array("personnage" => $personnage->getId()));
        //~~~~~~~~~~~~~~~~~~~~~~~formulaire pour les trois bar~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 
        $statForm = $this->get('form.factory')->createNamedBuilder('stat', FormType::class, $personnage)
            ->add('pv', IntegerType::class)
            ->add('pm', IntegerType::class)
            ->add('pc', IntegerType::class)
            ->getForm();
        //~~~~~~~~~~~~~~~~~~~~~~formulaire pour l'inventaire et les PO~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        $inventaireForm = $this->get('form.factory')->createNamedBuilder('inventaire', FormType::class, $personnage)
            ->add('inventaire', TextareaType::class)
            ->add('po', IntegerType::class)
            ->getForm();
        if ($request->getMethod() === 'POST') {
            $statForm->handleRequest($request);
            $inventaireForm->handleRequest($request);
            if ($request->request->has('stat')) {
                //dd($request);
                $entityManager->persist($personnage);
                $entityManager->flush();
                //
            }
            if ($request->request->has('inventaire')) {
                $entityManager->persist($personnage);
                $entityManager->flush();
                //
            }
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }

        //dd($inventaireForm);
        return $this->render('personnage/fichePersonnage.html.twig', [
            'personnage' => $personnage,
            'statForm' => $statForm->createView(),
            'inventaireForm' => $inventaireForm->createView(),
            'competences' => $competences,
            'armure' => $armure,
            'armes' => $armes,
        ]);
    }

    /**
     * @Route("/{id}/lore", name="modif_lore")
     */
    public function lore($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $loreForm = $this->createFormBuilder($personnage)
            ->add('lore', TextareaType::class, [
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
     * @Route("/{id}/level_up", name="level_up")
     */
    public function levulUp($id, Request $request, EntityManagerInterface $entityManager)
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
     * @Route("/{id}/image", name="change_image")
     */
    public function modifImage($id, Request $request, EntityManagerInterface $entityManager)
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
        ]);
    }

    /**
     * @Route("/{id}/armure", name="modif_armure")
     */
    public function modifArmure($id, Request $request, EntityManagerInterface $entityManager, PieceArmureRepository $pr)
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $armure = $this->getDoctrine()->getRepository(PieceArmurePersonnage::class)->findBy(array("personnage" => $personnage->getId()));
        $pieces = [1 => 'casque', 'plastron', 'jambiere', 'anneau', 'amulette', 'cape', 'bouclier'];
        $armureForm = $this->createFormBuilder();
        for ($i = 1; $i <= 7; $i++) {
            $str = 'effet_' . $pieces[$i];
            $armureForm->add($pieces[$i], EntityType::class, [
                'class' => PieceArmure::class,
                'choice_label' => 'type',
                'query_builder' => $this->optionType($i, $pr),
                'data' => $armure[$i - 1]->getPiece(),
                'attr' => ['class' => 'input-form']
            ])
                ->add($str, TextType::class, [
                    'required' => false,
                    'data' => $armure[$i - 1]->getEffet(),
                    'label' => 'Effet',
                    'attr' => ['class' => 'input-form']
                ]);
        }
        $armureForm = $armureForm->getForm();
        $armureForm->handleRequest($request);
        if ($armureForm->isSubmitted()) {

            for ($i = 1; $i <= 7; $i++) {
                $piece = $armureForm->get($pieces[$i])->getData();
                $effet = $armureForm->get('effet_' . $pieces[$i])->getData();
                $armure[$i - 1]->setPiece($piece);
                $armure[$i - 1]->setEffet($effet);

                $entityManager->persist($armure[$i - 1]);
                $entityManager->flush();
            }
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/equipement.html.twig', [
            'armureForm' => $armureForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    /**
     * @Route("/{id}/arme", name="modif_arme")
     */
    public function modifArme($id, Request $request, EntityManagerInterface $entityManager, PieceArmureRepository $pr)
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);
        $armes = $this->getDoctrine()->getRepository(ArmePersonnage::class)->findBy(array("personnage" => $personnage->getId()));
        //$pieces = [1 =>'casque', 'plastron', 'jambiere', 'anneau', 'amulette', 'cape', 'bouclier'];
        dump($armes);
        $armureForm = $this->createFormBuilder();
        for ($i = 1; $i <= 3; $i++) {
            $str = 'effet_' . $i;
            $armureForm->add('n_' . $i, EntityType::class, [
                'class' => Arme::class,
                'choice_label' => 'nom',
                //'query_builder' => $this->optionType($i, $pr),
                'data' => $armes[$i - 1]->getArme(),
                'attr' => ['class' => 'input-form'],
                'label' => 'Arme N°' . $i
            ])
                ->add($str, TextType::class, [
                    'required' => false,
                    'data' => $armes[$i - 1]->getEffet(),
                    'label' => 'Effet',
                    'attr' => ['class' => 'input-form']
                ]);
        }
        $armureForm = $armureForm->getForm();
        $armureForm->handleRequest($request);
        if ($armureForm->isSubmitted()) {

            for ($i = 1; $i <= 3; $i++) {
                $arme = $armureForm->get('n_' . $i)->getData();
                $effet = $armureForm->get('effet_' . $i)->getData();
                $armes[$i - 1]->setArme($arme);
                $armes[$i - 1]->setEffet($effet);

                $entityManager->persist($armes[$i - 1]);
                $entityManager->flush();
            }
            return $this->redirectToRoute('personnage_view', ["id" => $id]);
        }
        return $this->render('personnage/arme.html.twig', [
            'armureForm' => $armureForm->createView(),
            "personnage" => $personnage,
        ]);
    }

    private function optionType($id, PieceArmureRepository $pr)
    {
        return $pr->createQueryBuilder('p')
            ->where('p.localisation = :id')
            ->setParameter("id", $id);
    }
    public function removeFile($file)
    {
        $file_path = $this->getParameter('images_directory') . '/' . $file;
        if (file_exists($file_path)) unlink($file_path);
    }
}
