<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Form\ResourceFormType;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/administration/ressource", name:"admin_")]
class ResourceController extends AbstractController
{
    #[Route("/ajouter", name:"add_resource")]
    public function addClass(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newResource = new Resource();

        $resourceForm = $this->createForm(ResourceFormType::class, $newResource);
        $resourceForm->handleRequest($request);
        if ($resourceForm->isSubmitted() && $resourceForm->isValid()) {
            $entityManager->persist($newResource);
            $entityManager->flush();

            $this->addFlash("success", "La ressource a été ajoutée avec succès.");
            return $this->redirectToRoute("admin_resource_list");
        }
        return $this->render('admin/resource/form.html.twig', [
            "resourceForm" => $resourceForm->createView()
        ]);
    }
    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/liste", name:"resource_list")]
    public function classList(ResourceRepository $resourceRepository): Response
    {
        $resources = $resourceRepository->findBy([], ["id" => "ASC"]);
        return $this->render('admin/resource/list.html.twig', [
            "resources" => $resources
        ]);
    }

    /**
     * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
     */
    #[Route("/modifier/{id}", name:"update_resource")]
    public function updateClass(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        ResourceRepository $resourceRepository): Response
    {
        $resource = $resourceRepository->find($id);
        $resourceForm = $this->createForm(ResourceFormType::class, $resource);

        $resourceForm->handleRequest($request);
        if ($resourceForm->isSubmitted() && $resourceForm->isValid()) {
            $entityManager->persist($resource);
            $entityManager->flush();
            $this->addFlash("success", "La ressource a été modifiée avec succès.");
            return $this->redirectToRoute("admin_resource_list");
        }
        return $this->render('admin/resource/form.html.twig', [
            "resourceForm" => $resourceForm->createView()
        ]);
    }
}
