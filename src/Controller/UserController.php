<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            return $this->redirectToRoute('main_home');
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
                    return $this->redirectToRoute("profil");

                }
        }
        return $this->render("user/changePassword.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
