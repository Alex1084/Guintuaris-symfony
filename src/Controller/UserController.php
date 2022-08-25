<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Sheet;
use App\Form\ChangePasswordFormType;
use App\Form\UpdateUserFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * permet de voir les information de son profil
     *
     * @return Response
     */
    #[Route("/profil", name:"profil")]
    public function profilUser(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login"); 
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }

    #[Route("/profil/mot-de-passe", name:"profil_update_password")]
    public function updatePassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)  : Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (password_verify($form->get("ancientPassword")->getData(), $this->getUser()->getPassword())) {
                    
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get("plainPassword")->getData()
                        )
                    );

                    $entityManager->persist($this->getUser());
                    $entityManager->flush();
                    $this->addFlash("success","votre nouveau mot de passe a été enregistré");
                    return $this->redirectToRoute("profil");

                }
        }
        return $this->render("user/changePassword.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[Route("profil/modifier", name:"profil_update_account")]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute("app_login");
        }
        $userForm = $this->createForm(UpdateUserFormType::class, $user);
        
        $userForm->handleRequest($request);
        // dd($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if (password_verify($userForm->get("password")->getData(), $this->getUser()->getPassword())) {
                    
                // $user->setUpdatedAt(new DateTimeImmutable());
                $entityManager->persist($this->getUser());
                $entityManager->flush();
                    $this->addFlash("success","les modification de votre compte ont été enregistré");
                    return $this->redirectToRoute("profil");

            }
            // dd("error");
        }

        return $this->render("user/update.html.twig", [
            "userForm" => $userForm->createView()
        ]);
    }

    #[Route("profil/supprimer", name: "profile_delete")]
    public function deleteProfil(EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute("app_login");
        }
        $sheets = $doctrine->getRepository(Character::class)->findBy(["user" => $user]);
        foreach ($sheets as $sheet) {
            $file_path = $this->getParameter('images_directory') . '/' . $sheet->getImage();
            if (file_exists($file_path)) unlink($file_path);
            $entityManager->remove($sheet);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        $session = new Session();
        $session->invalidate();
        $this->addFlash("success","votre compte a été supprimmer");
        return $this->redirectToRoute("app_logout");
    }

    #[Route("desactiver", name: "deactivate")]
    public function deactivate()
    {
        if ($this->isGranted("ROLE_DEACTIVATE")) {
            return $this->render("user/deactivate.html.twig", [
                "name" => $this->getUser()->getName()
            ]);
        }
        return $this->redirectToRoute("main_home");
    }
}
