<?php

namespace App\Controller;

use App\Entity\Personnage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
    /**
     * @Route("/personnage", name="personnage_")
     */
class PersonnageController extends AbstractController
{
    /**
     * @Route("/{id}", name="view")
     */
    public function index($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personnage::class);
        $personnage = $repo->find($id);

        dd($personnage);
        return $this->render('personnage/index.html.twig',[
            'personnage' => $personnage
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        return $this->render('personnage/list.html.twig');
    }

    /**
     * @Route("/creation", name="create")
     */
    public function create(): Response
    {
        return $this->render('personnage/creation.html.twig');
    }

    
}
