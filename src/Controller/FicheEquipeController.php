<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Personnage;
use App\Entity\WeaponCharacter;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipe", name="equipe_")
 */
class FicheEquipeController extends AbstractController
{
    /**
     * cette page affiche la list des membre apartenent à l'equipe qui se trouve en parametre
     * l'objectif serais qu'un joueur qui n'a pas de personnage dans une equipe ne puisse pas y acceder par l'url
     * 
     * @Route("/list/{idEquipe}", name="list")
     *
     * @param int $idEquipe
     * @return Response
     */
    public function listEquipe(int $idEquipe): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnages = $repo->findBy(array('equipe' => $idEquipe), array('nom' => 'ASC'));
        return $this->render('fiche_equipe/listEquipe.html.twig', [
            "personnages" => $personnages
        ]);
    }
    /**
     * cette page affiche une fiche de personnage qui ne peut pas être editer
     * le membre y on seulement un accee afin de pouvoir voir les fiche des membre de leur equipe
     * 
     * @Route("/{idEquipe}/fiche/{idPersonnage}", name="fiche_view")
     *
     * @param integer $idEquipe
     * @param integer $idPersonnage
     * @param CompetenceRepository $compRepo
     * @return Response
     */
    public function fichePerso(int $idEquipe, int $idPersonnage, CompetenceRepository $compRepo): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($idPersonnage);
        //requete pour les competence
        $competences = $compRepo->findByLevel($personnage->getNiveau(), $personnage->getClasse()->getId());

        //requete pour les armes et armures
        $repo = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class);
        $armor = $repo->findBy(["charact" => $personnage->getId()]);
        $repo = $this->getDoctrine()->getRepository(WeaponCharacter::class);
        $weapons = $repo->findBy(["charact" => $personnage->getId()]);

        // creation d'un formulaire en readonly pour voir le statut
        $statForm = $this->get('form.factory')->createNamedBuilder('stat', FormType::class, $personnage)
            ->add('pv', IntegerType::class)
            ->add('pm', IntegerType::class)
            ->add('pc', IntegerType::class)
            ->getForm();

        return $this->render('fiche_equipe/ficheEquipier.html.twig', [
            'idEquipe' => $idEquipe,
            'personnage' => $personnage,
            'statForm' => $statForm->createView(),
            'competences' => $competences,
            'armor' => $armor,
            'weapons' => $weapons
        ]);
    }
}
