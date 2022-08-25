<?php

namespace App\Controller\Admin;

use App\Entity\Weapon;
use App\Form\WeaponFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administration/arme', name: 'admin_')]
class WeaponController extends AbstractController
{    
    /**
    * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
    */
    #[Route("/ajouter", name:"add_weapon")]
   public function addWeapon(Request $request, EntityManagerInterface $entityManager): Response
   {
       $weapon = new Weapon();
       $weaponForm = $this->createForm(WeaponFormType::class, $weapon);

       $weaponForm->handleRequest($request);
       if ($weaponForm->isSubmitted() && $weaponForm->isValid()) {

           $entityManager->persist($weapon);
           $entityManager->flush();
           $this->addFlash("success", "l'arme ".$weapon->getName()." a été crée, les personnage peuvent désormais l'equipé");
           return $this->redirectToRoute("admin_weapon_list");
       }
       return $this->render('admin/weapon/form.html.twig', [
           "weaponForm" => $weaponForm->createView()
       ]);
   }
   /**
    * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
    */
    #[Route("/liste", name:"weapon_list")]
   public function weaponList(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
   {
       $weapons = $doctrine->getRepository(Weapon::class)->findAll();
       return $this->render('admin/weapon/list.html.twig', [
           'weapons' => $weapons
       ]);
   }

   /**
    * permet d'ajouter une nouvelle competence dans la base de donnée (table competence)
    */
    #[Route("/modifier/{weaponId}", name:"update_weapon")]
   public function updateWeapon(int $weaponId, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
   {
       $weapon = $doctrine->getRepository(Weapon::class)->find($weaponId);
       $weaponForm = $this->createForm(WeaponFormType::class, $weapon);

       $weaponForm->handleRequest($request);
       if ($weaponForm->isSubmitted() && $weaponForm->isValid()) {

           $entityManager->persist($weapon);
           $entityManager->flush();
           $this->addFlash("success", "l'arme ".$weapon->getName()." a été mis a jour");
           return $this->redirectToRoute("admin_weapon_list");
       }
       return $this->render('admin/weapon/form.html.twig', [
           "weaponForm" => $weaponForm->createView()
       ]);
   }

   /**
    * Undocumented function
    */
    #[Route("/supprimer/{weaponId}", name:"delete_weapon")]
   public function deleteWeapon(int $weaponId, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
   {
       $weapon = $doctrine->getRepository(Weapon::class)->find($weaponId);
           $entityManager->remove($weapon);
           $entityManager->flush();
           return $this->json("delete Succes");
   }
}
