<?php

namespace App\Controller;

use App\Entity\Bestiaire;
use App\Form\BoardType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestiaireController extends AbstractController
{
    /**
     * @Route("/bestiaire", name="bestiaire")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bete = new Bestiaire();
        $repo = $this->getDoctrine()->getRepository(Bestiaire::class);
        $beteForm = $this->createForm(BoardType::class, $bete);
        $beteForm->handleRequest($request);
        if ($beteForm->isSubmitted()) {
            $bete = $repo->find($beteForm->get("bete")->getData());
        }
        return $this->render('bestiaire/mjboard.html.twig', [
            'beteForm' => $beteForm->createView(),
            'bete' => $bete,
        ]);
    }

    /**
     * @Route("admin/summon/{id}", name="summon")
     *
     * @param integer $id
     * @param ObjectManager $manager
     * @return void
     */
    public function beteToJson(int $id/*,  ObjectManage $manager */): Response
    {
        $bete = $this->getDoctrine()->getRepository(Bestiaire::class)->find($id);
        return $this->json(["code" => 200, 'bete' => $bete], 200);
    }
}
