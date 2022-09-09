<?php

namespace App\Controller\Master;

use App\Entity\Character;
use App\Entity\Team;
use App\Repository\CharacterRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/maitre-du-jeu", name:"master_")]
class TeamController extends AbstractController
{
    /**
     * affiche le nom de toute les equipe et emment ensuite vers master_add_membre
     * de plus un formulaire permet de créer une nouvelle equipe
     */
    #[Route("/equipe", name:"team_list")]
    public function teamListAdmin(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $allTeam = $doctrine->getRepository(Team::class)->findBy(["master" => $this->getUser()], ["name" => "asc"]);
        $newTeam = new Team();
        $form = $this->TeamForm($newTeam, $request,$entityManager);
        if ($form->isSubmitted()) {
            return $this->redirectToRoute("master_add_member", ['teamId' => $newTeam->getId(), "slug" => $newTeam->getSlug()]);
        }
        return $this->render('master/team/listTeam.html.twig', [
            'teams' => $allTeam,
            'addTeamForm' => $form->createView(),
        ]);
    }
    #[Route('/lists', name: 'list_character_team')]
    public function index(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $allTeam = $doctrine->getRepository(Team::class)->findBy(["master" => $this->getUser()], ["name" => "asc"]);
        $characters = $doctrine->getRepository(Character::class)->listByUser($this->getUser()->getId());
        $newTeam = new Team();
        $form = $this->TeamForm($newTeam, $request,$entityManager);
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
    public function teamRename(int $teamId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $team = $doctrine->getRepository(Team::class)->find($teamId);
        if ($team->getMaster() !== $this->getUser()) {
            return $this->redirectToRoute("master_team_list");
        }
        if ($request->isMethod('post')) {
            if ($team->getMaster() !== $this->getUser()) {
                $this->addFlash("error", "access denied");
                return $this->redirectToRoute("master_team_list");
            }
            $newName = $request->request->get("value");
            if (strlen($newName) <= 3) {
                $this->addFlash("error", "nom invalie, le nom de l'quipe doit faire entre 3 et 50 caractère ");
                return $this->redirectToRoute("master_team_list");
            }
            $slugify = new Slugify();
            $slug = $slugify->slugify($newName);
            $oldName = $team->getName();
            $team->setSlug($slug)
                    ->setName($newName);
            $entityManager->persist($team);
            $entityManager->flush();
            $this->addFlash("success", "l'equipe ".$oldName." a été renommé en ".$newName);
        }
        return $this->redirectToRoute("master_team_list");
    }

    #[Route("/supprimer-equipe/{id}", name:"delete_team")]
    public function deleteTeam(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $team = $doctrine->getRepository(Team::class)->find($id);
        if ($this->getUser()->getId() === $team->getMaster()) {
            $entityManager->remove($team);
            $entityManager->flush();
            return $this->json("delete Succes");
        }
        return $this->json("access denied", 403);
    }

    /**
     * affiche dans un select tout les personnage present dans l'equipe aucune
     * lorsque le formulaire est valider le persnnage selectioner changer d'equipe et a pour equipe celle selectionner dans la page master_equipe_list
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
                $this->addFlash("error", "aucun personnage n'est selectionner");
                return $this->redirectToRoute('master_add_member', ['teamId' => $teamId, "slug" => $slug]);
            }
            foreach ($selectedCharacters as $character) {
                $character->setTeam($team);
                $entityManager->persist($character);
            }
            $entityManager->flush();
            $this->addFlash("success", "le nouveau membre a été ajouté avec succés");
            return $this->redirectToRoute('master_add_member', ['teamId' => $teamId, "slug" => $slug]);
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
        $team = $doctrine->getRepository(Team::class)->find($character->getTeam());
        if (!$team || $team->getMaster() !== $this->getUser()) {
            return $this->json("access denied", 403);
        }
        $character->setTeam(null);
        $entityManager->persist($character);
        $entityManager->flush();
        return $this->json("delete Succes");
    }

    private function TeamForm(Team $newTeam, Request $request, EntityManagerInterface $entityManager)
    {
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
            $this->addFlash("success", "l'equipe ".$newTeam->getName()." a été créé avec succés");
        }
        return $form;
    }
}
