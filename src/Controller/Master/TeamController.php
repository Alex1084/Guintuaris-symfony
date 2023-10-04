<?php

namespace App\Controller\Master;

use App\Entity\Character;
use App\Entity\Team;
use App\Repository\CharacterRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route("/maitre-du-jeu", name:"master_")]
class TeamController extends AbstractController
{
    /**
     * affiche le nom de toute les equipe et emment ensuite vers master_add_membre
     * de plus un formulaire permet de créer une nouvelle equipe
     */
    #[Route("/equipe", name:"team_list")]
    public function teamListAdmin(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        TeamRepository $teamRepository): Response
    {
        $allTeam = $teamRepository->findBy(["master" => $this->getUser()], ["name" => "asc"]);
        $newTeam = new Team();
        $form = $this->TeamForm($newTeam, $request,$entityManager,$slugger);
        if ($form->isSubmitted()) {
            return $this->redirectToRoute("master_add_member", ['teamId' => $newTeam->getId(), "slug" => $newTeam->getSlug()]);
        }
        return $this->render('master/team/listTeam.html.twig', [
            'teams' => $allTeam,
            'addTeamForm' => $form->createView(),
        ]);
    }

    #[Route('/lists', name: 'list_character_team')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        TeamRepository $teamRepository,
        SluggerInterface $slugger,
        CharacterRepository $characterRepository): Response
    {
        $allTeam = $teamRepository->findBy(["master" => $this->getUser()], ["name" => "asc"]);
        $characters = $characterRepository->listByUser($this->getUser()->getId());
        $newTeam = new Team();
        $form = $this->TeamForm($newTeam, $request,$entityManager, $slugger);
        if ($form->isSubmitted()) {
            return $this->redirectToRoute("master_add_member", ['teamId' => $newTeam->getId(), "slug" => $newTeam->getSlug()]);
        }
        return $this->render('master/team/list.html.twig', [
            "characters" => $characters,
            'teams' => $allTeam,
            'addTeamForm' => $form->createView(),
        ]);
    }

    #[Route("/modifer-equipe/{teamId}", name:"team_rename")]
    public function teamRename(
        int $teamId,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->find($teamId);
        if ($team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("master_team_list");
        }
        if ($request->isMethod('post')) {
            if ($team->getMaster() !== $this->getUser()) {
                $this->addFlash("error", "Accès refusé, vous n'avez pas accès à cette fonctionnalité.");
                return $this->redirectToRoute("master_team_list");
            }
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3) {
                $this->addFlash("error", "Le nom invalide, le nom de l'quine doit faire entre 3 et 50 caractères.");
                return $this->redirectToRoute("master_team_list");
            }
            $slug = $slugger->slug($newName);
            $oldName = $team->getName();
            $team->setSlug($slug)
                    ->setName($newName);
            $entityManager->persist($team);
            $entityManager->flush();
            $this->addFlash("success", "L'équipe ".$oldName." a été renommée en ".$newName.".");
        }
        return $this->redirectToRoute("master_team_list");
    }

    #[Route("/supprimer-equipe/{id}", name:"delete_team")]
    public function deleteTeam(
        int $id,
        EntityManagerInterface $entityManager,
        TeamRepository $teamRepository)
    {
        $team = $teamRepository->find($id);
        if ($this->getUser()->getId() === $team->getMaster()) {
            $entityManager->remove($team);
            $entityManager->flush();
            return $this->json("Supprimé avec succès");
        }
        return $this->json("Accès refusé, vous n'avez pas accès à cette action.", 403);
    }

    /**
     * affiche dans un select tout les personnage present dans l'equipe aucune
     * lorsque le formulaire est valider le persnnage selectioner changer d'equipe et a pour equipe celle selectionner dans la page master_equipe_list
     * de plus la page affiche le nom de tout les personnage apartenent a l'equipe (les nom emmenent ensuite vers leur fiche)
     */
    #[Route('/ajout-membre/{slug}/{teamId}', name: 'add_member')]
    public function addTeamMember(
        string $slug,
        int $teamId,
        Request $request,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository,
        TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->findOneBy(["slug" => $slug, "id" => $teamId]); //represente la L'equipe sur la quelle des membre vont etre ajouter
        if (!$team || $team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("master_team_list");
        }
        $teamMembers = $characterRepository->findNameByTeam($teamId); //list des Memebre apartennant a cette equipe
        $memberForm = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                // 'choice_label' => 'name',
                'query_builder' => function (CharacterRepository $pr) {
                    return $pr->createQueryBuilder('c')
                        ->where('c.team IS NULL')
                        ->orderBy('c.name', 'ASC');
                },
                'multiple' => true,
                // 'expanded'=>true,
            ])
            ->getForm();
        $memberForm->handleRequest($request);
        if ($memberForm->isSubmitted() && $memberForm->isValid()) {
            $selectedCharacters = $memberForm->get('character')->getData();
            if ($selectedCharacters === null) {
                $this->addFlash("error", "Erreur, vous n'avez sélectionné aucun personnage.");
                return $this->redirectToRoute('master_add_member', ['teamId' => $teamId, "slug" => $slug]);
            }
            foreach ($selectedCharacters as $character) {
                $character->setTeam($team);
                $entityManager->persist($character);
            }
            $entityManager->flush();
            $this->addFlash("success", "Le nouveau membre a été ajouté avec succès.");
            return $this->redirectToRoute('master_add_member', ['teamId' => $teamId, "slug" => $slug]);
        }
        return $this->render('master/team/listTeamMember.html.twig', [
            'memberForm' => $memberForm->createView(),
            'team' => $team,
            'teamMembers' => $teamMembers,
        ]);
    }

    #[Route("/retire-membre/{characterId}", name:"delete_team_member")]
    public function deleteTeamMember(
        int $characterId,
        EntityManagerInterface $entityManager,
        CharacterRepository $characterRepository,
        TeamRepository $teamRepository)
    {
        $character = $characterRepository->find($characterId);
        $team = $teamRepository->find($character->getTeam());
        if (!$team || $team->getMaster() !== $this->getUser()) {
            return $this->json("Accès refusé, vous n'avez pas accès à cette action.", 403);
        }
        $character->setTeam(null);
        $entityManager->persist($character);
        $entityManager->flush();
        return $this->json("Supprimé avec succès");
    }

    private function TeamForm(
        Team $newTeam,
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger)
    {
        $form = $this->createFormBuilder($newTeam)
        ->add('name', TextType::class)
        ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $slug = $slugger->slug($newTeam->getName());
            $newTeam->setSlug($slug)
                    ->setMaster($this->getUser());
            $entityManager->persist($newTeam);
            $entityManager->flush();
            $this->addFlash("success", "L'équipe ".$newTeam->getName()." a été créée avec succès.");
        }
        return $form;
    }
}
