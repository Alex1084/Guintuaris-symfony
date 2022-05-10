<?php

namespace App\Controller;

use App\Entity\ArmorPieceCharacter;
use App\Entity\Character;
use App\Entity\WeaponCharacter;
use App\Repository\SkillRepository;
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
     */
    public function listEquipe(int $idEquipe): Response
    {
        $repo = $this->getDoctrine()->getRepository(Character::class);
        $characters = $repo->findBy(['team' => $idEquipe], ['name' => 'ASC']);
        return $this->render('fiche_equipe/listEquipe.html.twig', [
            "characters" => $characters
        ]);
    }
    /**
     * cette page affiche une fiche de personnage qui ne peut pas être editer
     * le membre y on seulement un accee afin de pouvoir voir les fiche des membre de leur equipe
     * 
     * @Route("/{idEquipe}/fiche/{characterId}", name="fiche_view")
     *
     */
    public function fichePerso(int $idEquipe, int $characterId, SkillRepository $skillRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(Character::class);
        $character = $repo->find($characterId);
        //requete pour les competence
        $skills = $skillRepository->findByLevel($character->getLevel(), $character->getClass()->getId());

        //requete pour les armes et armures
        $repo = $this->getDoctrine()->getRepository(ArmorPieceCharacter::class);
        $armor = $repo->findBy(["charact" => $character->getId()]);
        $repo = $this->getDoctrine()->getRepository(WeaponCharacter::class);
        $weapons = $repo->findBy(["charact" => $character->getId()]);

        // creation d'un formulaire en readonly pour voir le statut
        $statForm = $this->get('form.factory')->createNamedBuilder('stat', FormType::class, $character)
            ->add('pv', IntegerType::class)
            ->add('pm', IntegerType::class)
            ->add('pc', IntegerType::class)
            ->getForm();

        return $this->render('fiche_equipe/ficheEquipier.html.twig', [
            'idEquipe' => $idEquipe,
            'character' => $character,
            'statForm' => $statForm->createView(),
            'skills' => $skills,
            'armor' => $armor,
            'weapons' => $weapons
        ]);
    }
}
