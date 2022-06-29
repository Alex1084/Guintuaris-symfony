<?php

namespace App\Controller\AdminCRUD;

use App\Entity\ArmorLocation;
use App\Entity\ArmorType;
use App\Entity\BestiaryType;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 */
#[Route("/admin", name:"admin_")]
class AdminTableController extends AbstractController
{

    /**
     * permet d'ajouter un nouveau type de bete dans la base de donné (table type_bestiaire)
     * affiche toute les instance se trouvant dans cette table
     */
    #[Route("/list-type-bestiaire", name:"bestiary_type_list")]
    public function addBestiaryType(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $restict = true;
        $pathDeleteName = "admin_delete_bestiary_type";
        $newType = new BestiaryType();

        $results = $this->createFormTable($newType, $request, $entityManager, $doctrine);

        if ($results['formulaire']->isSubmitted()) {
            return $this->redirectToRoute('admin_bestiary_type_list');
        }
        //dd($results['formulaire']);
        return $this->render('admin/listTable.html.twig', [
            'list' => $results['dataList'],
            'form' => $results['formulaire']->createView(),
            'pathDeleteName' => $pathDeleteName
        ]);
    }

    /**
     * Undocumented function
     *
     */
    private function createFormTable(Object $objet, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $repo = $doctrine->getRepository(get_class($objet));
        $findall = $repo->findAll();
        $form = $this->createFormBuilder($objet)
            ->add('name', TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($objet);
            $entityManager->flush();
        }

        $array = ['dataList' => $findall, 'formulaire' => $form];
        return $array;
    }
}
