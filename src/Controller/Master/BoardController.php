<?php

namespace App\Controller\Master;

use App\Repository\BestiaryRepository;
use App\Repository\BestiaryTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoardController extends AbstractController
{
    /**
     * affiche un page qui permet d'afficher des carte de bete se trouvant dans le bestiaire
     * cette page est utile au mj uniquement durant des partie
     */
    #[Route('/maitre-du-jeu/tableau', name: 'board')]
    public function index(
        BestiaryTypeRepository $bestiaryTypeRepository,
        BestiaryRepository $bestiaryRepository
    ): Response
    {
        $bestiaryType = $bestiaryTypeRepository->findBy([], ["name" => "ASC"]);
        $bestiaryList = $bestiaryRepository->bestiaryBoard();
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
        return $this->render('master/board/mjboard.html.twig', [
            "list" => $list,
        ]);
    }

    /**
     * renvoie un reponse json pour afficher les carte dans le mj board
     * grace a des lien contennent un identifiant, 
     * une bete du bestiaire va etre appeler et est interpreter par une requete ajax se trouvant dans le fichier miniFiche.js
     */
    #[Route('/maitre-du-jeu/invoquation/{id}', name: 'summon')]
    public function beteToJson(
        int $id,
        BestiaryRepository $bestiaryRepository): Response
    {
        $creature = $bestiaryRepository->find($id);
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
