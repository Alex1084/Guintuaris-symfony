<?php

namespace App\Controller\Admin;

use Cocur\Slugify\Slugify;
use App\Entity\Character;
use App\Entity\Team;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/administration/equipe", name:"admin_")]
class TeamController extends AbstractController
{

    /**
     * affiche le nom de toute les equipe et emment ensuite vers admin_add_membre
     * de plus un formulaire permet de créer une nouvelle equipe
     */
    #[Route("", name:"team_list")]
    public function teamListAdmin(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newTeam = new Team();
        $allTeam = $doctrine->getRepository(Team::class)->findBy([], ["name" => "ASC"]);
        $form = $this->createFormBuilder($newTeam)
            ->add('name', TextType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $slugify = new Slugify();
            $slug = $slugify->slugify($newTeam->getName());
            $newTeam->setSlug($slug)
                    ->setMaster($this->getUser());
            $entityManager->persist($newTeam);
            $entityManager->flush();
            $this->addFlash("success", "L'équipe ".$newTeam->getName()." a été créée avec succès.");
            return $this->redirectToRoute("admin_add_member", ['teamId' => $newTeam->getId(), "slug" => $newTeam->getSlug()]);
        }
        return $this->render('master/team/listTeam.html.twig', [
            'teams' => $allTeam,
            'addTeamForm' => $form->createView(),
        ]);
    }

    #[Route("/modifier/{teamId}", name:"team_rename")]
    public function teamRename(int $teamId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('post')) {
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3) {
                $this->addFlash("error", "Nom invalide, le nom de l'équipe doit faire entre 3 et 50 caractères.");
                return $this->redirectToRoute("admin_team_list");
            }
            $team = $doctrine->getRepository(Team::class)->find($teamId);
            $slugify = new Slugify();
            $slug = $slugify->slugify($newName);
            $oldName = $team->getName();
            $team->setSlug($slug)
                    ->setName($newName)
                    ->setMaster($this->getUser());
            $entityManager->persist($team);
            $entityManager->flush();
            $this->addFlash("success", "L'équipe ".$oldName." a été renommée en ".$newName.".");
        }
        return $this->redirectToRoute("admin_team_list");
    }

    #[Route("/supprimer/{id}", name:"delete_team")]
    public function deleteTeam(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $team = $doctrine->getRepository(Team::class)->find($id);
            $entityManager->remove($team);
            $entityManager->flush();
            return $this->json("Supprimé avec succès");
    }

    /**
     * affiche dans un select tout les personnage present dans l'equipe aucune
     * lorsque le formulaire est valider le persnnage selectioner changer d'equipe et a pour equipe celle selectionner dans la page admin_equipe_list
     * de plus la page affiche le nom de tout les personnage apartenent a l'equipe (les nom emmenent ensuite vers leur fiche)
     * 
     *
     * @param integer $teamId
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CharacterRepository $characterRepository
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/ajout-membre/{slug}/{teamId}', name: 'add_member')]
    public function addTeamMember(string $slug, int $teamId, Request $request, EntityManagerInterface $entityManager, CharacterRepository $characterRepository, ManagerRegistry $doctrine): Response
    {
        $team = $doctrine->getRepository(Team::class)->findOneBy(["slug" => $slug, "id" => $teamId]); //represente la L'equipe sur la quelle des membre vont etre ajouter
        if (!$team) {
            return $this->redirectToRoute("admin_team_list");
        }
        $teamMembers = $characterRepository->findNameByTeam($teamId); //list des Memebre apartennant a cette equipe
        $memberForm = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'name',
                'query_builder' => function (CharacterRepository $pr) {
                    return $pr->createQueryBuilder('c')
                        ->where('c.team IS NULL')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->getForm();
        $memberForm->handleRequest($request);
        if ($memberForm->isSubmitted()) {
            $selectedCharacter = $memberForm->get('character')->getData();
            $selectedCharacter->setTeam($team);
            $entityManager->persist($selectedCharacter);
            $entityManager->flush();
            $this->addFlash("success", "Le nouveau membre a été ajouté avec succès.");
            return $this->redirectToRoute('admin_add_member', ['teamId' => $teamId, "slug" => $slug]);
        }
        return $this->render('master/team/listTeamMember.html.twig', [
            'memberForm' => $memberForm->createView(),
            'team' => $team,
            'teamMembers' => $teamMembers,
        ]);
    }

    #[Route("/retire-membre/{characterId}", name:"delete_team_member")]
    public function deleteTeamMember(int $characterId, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $character = $doctrine->getRepository(Character::class)->find($characterId);
        // if ($this->getUser()->getRoles() === "ROLE_ADMIN") {
            $character->setTeam(null);
            $entityManager->persist($character);
            $entityManager->flush();
            return $this->json("Supprimé avec succès");
        // } else {
            return $this->json("Accès refusé, vous n'avez pas accès à cette action.", 403);
        // }
    }
}
