<?php

namespace App\Controller;

use App\Entity\Bestiary;
use App\Repository\BestiaireRepository;
use App\Repository\BestiaryRepository;
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
     * affiche un page qui permet d'afficher des carte de bete se trouvant dans le bestiaire
     * cette page est utile au mj uniquement durant des partie
     * 
     * @Route("admin/board", name="bestiaire")
     * 
     * 
     */
    public function index(BestiaryRepository $bRepo): Response
    {
        $monstres = $bRepo->findAllName(1);
        $animaux = $bRepo->findAllName(2);
        return $this->render('bestiaire/mjboard.html.twig', [
            'monstres' => $monstres,
            'animaux' => $animaux
        ]);
    }

    /**
     * renvoie un reponse json pour afficher les carte dans le mj board
     * grace a des lien contennent un identifiant, 
     * une bete du bestiaire va etre appeler et est interpreter par une requete ajax se trouvant dans le fichier miniFiche.js
     * @Route("admin/summon/{id}", name="summon")
     *
     */
    public function beteToJson(int $id): Response
    {
        $bete = $this->getDoctrine()->getRepository(Bestiary::class)->find($id);
        //dd($bete);
        return $this->json(
            $bete,
            200,
            /* [],
            ['groups' => ["read", "note"]] */
        );
        //return $this->json(["code" => 200, 'bete' => $bete], 200);
    }
}
