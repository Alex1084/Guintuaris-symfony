<?php

namespace App\Controller;

use App\Entity\Bestiary;
use App\Entity\BestiaryType;
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
    #[Route('/maitre-du-jeu/tableau', name: 'board')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $bestiaryType = $doctrine->getRepository(BestiaryType::class)->findAll();
        $bestiaryList = $doctrine->getRepository(Bestiary::class)->bestiaryBoard();
        $ids = array_map(function ($type)
        {

            return $type->getId();
        }, $bestiaryType);
        $list = [];
        foreach ($bestiaryType as $key => $type) {
            $list[$key]["beasts"] = [];
            $list[$key]["typeName"] = $type->getName();
            $list[$key]["typeID"] = $type->getId();
        }
        foreach ($bestiaryList as $beast) {
            $index = array_search($beast["typeID"], $ids);
            if ($index !== false) {
                array_push($list[$index]["beasts"], $beast);
            }
        }
        return $this->render('bestiaire/mjboard.html.twig', [
            "list" => $list,
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
    #[Route('/maitre-du-jeu/invoquation/{id}', name: 'summon')]
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
