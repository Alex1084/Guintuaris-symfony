<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Competence;
use App\Entity\Race;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{
    /**
     * @Route("/race/{id}", name="race")
     */
    public function race($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Race::class);
        $race = $repo->find($id);
        return $this->render('race/index.html.twig', [
            'race' => $race
        ]);
    }
     /**
     * @Route("/classe/{id}", name="classe")
     */
    public function classe($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Classe::class);
        $classe = $repo->find($id);

        $repo = $this->getDoctrine()->getRepository(Competence::class);
        $competences = $repo->findBy(array("classe" => $classe));
        return $this->render('race/classe.html.twig', [
            'classe' => $classe,
            'competences' => $competences
        ]);
    }
}
