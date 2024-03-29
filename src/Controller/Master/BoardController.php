<?php

namespace App\Controller\Master;

use App\Repository\CreatureRepository;
use App\Repository\CreatureTypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoardController extends AbstractController
{
    /**
     * affiche un page qui permet d'afficher des carte de bete se trouvant dans le bestiaire
     * cette page est utile au mj uniquement durant des partie
     */
    #[Route('/maitre-du-jeu/tableau', name: 'board')]
    public function board(
        CreatureTypeRepository $creatureTypeRepository,
        CreatureRepository $creatureRepository
    ): Response
    {
        $creatureType = $creatureTypeRepository->findBy([], ["name" => "ASC"]);
        $creatureList = $creatureRepository->getAllName();
        $ids = array_map(function ($type)
        {
            return $type->getId();
        }, $creatureType);
        $list = [];
        foreach ($creatureType as $key => $type) {
            $list[$key]["beasts"] = [];
            $list[$key]["typeName"] = $type->getName();
            $list[$key]["typeID"] = $type->getId();
        }
        foreach ($creatureList as $beast) {
            $index = array_search($beast["typeID"], $ids);
            if ($index !== false) {
                array_push($list[$index]["beasts"], $beast);
            }
        }
        return $this->render('master/board/mjboard.html.twig', [
            "list" => $list,
        ]);
    }

    /**
     * renvoie un reponse json pour afficher des mini fiche dans le mj board
     * grace a des lien contennent l'identifiant d'une creature, 
     * une bete du bestiaire va etre appeler et est interpreter par une requete ajax se trouvant dans le fichier miniFiche.js
     */
    #[Route('/maitre-du-jeu/invoquation/{id}', name: 'summon')]
    public function creatureToJson(
        int $id,
        CreatureRepository $creatureRepository): Response
    {
        $creature = $creatureRepository->find($id);
        return $this->json(
            $creature,
            200,
        );
    }
}
