<?php

namespace App\Controller;

use App\Entity\Bestiaire;
use App\Entity\TypeBestiaire;
use App\Form\BoardType;
use App\Repository\BestiaireRepository;
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
     * @Route("admin/board", name="bestiaire")
     */
    public function index(BestiaireRepository $bRepo): Response
    {
        $monstres = $bRepo->findAllNom(1);
        $animaux = $bRepo->findAllNom(2);
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
     * @param integer $id
     * @param ObjectManager $manager
     * @return void
     */
    public function beteToJson(int $id/*,  ObjectManage $manager */): Response
    {
        $bete = $this->getDoctrine()->getRepository(Bestiaire::class)->find($id);
        return $this->json(
            $bete,
            200,
            [],
            ['groups' => "read"]
        );
        //return $this->json(["code" => 200, 'bete' => $bete], 200);
    }
}
