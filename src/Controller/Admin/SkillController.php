<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use App\Form\SkillFormType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class SkillController extends AbstractController
{

     /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     * 
     * @Route("/ajouter-competence", name="add_skill")
     *
     */
    public function addSkill(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill();
        $skillForm = $this->createForm(SkillFormType::class, $skill);

        $skillForm->handleRequest($request);
        if ($skillForm->isSubmitted()) {

            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute("admin_skill_list");
        }
        return $this->render('admin/skill/form.html.twig', [
            "skillForm" => $skillForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     * 
     * @Route("/competence-list", name="skill_list")
     *
     */
    public function skillList(Request $request, EntityManagerInterface $entityManager, SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->skillList();
        return $this->render('admin/skill/list.html.twig', [
            'skills' => $skills
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     * 
     * @Route("/modifier-competence/{skillId}", name="update_skill")
     *
     */
    public function updateSkill(int $skillId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($skillId);
        $skillForm = $this->createForm(SkillFormType::class, $skill);

        $skillForm->handleRequest($request);
        if ($skillForm->isSubmitted()) {

            $entityManager->persist($skill);
            $entityManager->flush();
            return $this->redirectToRoute("admin_skill_list");
        }
        return $this->render('admin/skill/form.html.twig', [
            "skillForm" => $skillForm->createView()
        ]);
    }

    /**
     * Undocumented function
     * @Route("/supprimer-competence/{skillId}", name="delete_skill")
     */
    public function deleteSkill(int $skillId, EntityManagerInterface $entityManager)
    {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($skillId);
            $entityManager->remove($skill);
            $entityManager->flush();
            return $this->json("delete Succes");
    }
}
