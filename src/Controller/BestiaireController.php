<?php

namespace App\Controller;

use App\Entity\Bestiary;
use App\Repository\BestiaryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestiaireController extends AbstractController
{
    /**
     * affiche un page qui permet d'afficher des carte de bete se trouvant dans le bestiaire
     * cette page est utile au mj uniquement durant des partie
     *
     * @param BestiaryRepository $bestiaryRepository
     * @return Response
     */
    #[Route('/admin/board', name: 'board')]
    public function index(BestiaryRepository $bestiaryRepository): Response
    {
        $bestiaryList = $bestiaryRepository->findAll();
        return $this->render('bestiaire/mjboard.html.twig', [
            "bestiaryList" => $bestiaryList
        ]);
    }

    /**
     * renvoie un reponse json pour afficher les carte dans le mj board
     * grace a des lien contennent un identifiant, 
     * une bete du bestiaire va etre appeler et est interpreter par une requete ajax se trouvant dans le fichier miniFiche.js
     *
     * @param integer $id
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/admin/summon/{id}', name: 'summon')]
    public function beteToJson(int $id, ManagerRegistry $doctrine): Response
    {
        $creature = $doctrine->getRepository(Bestiary::class)->find($id);
        //dd($bete);
        return $this->json(
            $creature,
            200,
            /* [],
            ['groups' => ["read", "note"]] */
        );
        //return $this->json(["code" => 200, 'bete' => $bete], 200);
    }
}
