<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UpdateUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin", name:"admin_")]
class UserController extends AbstractController
{
    #[Route('/liste-utilisateur', name: 'user_list')]
    public function userlist(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('admin/user/userList.html.twig', [
            "users" => $users
        ]);
    }

    #[Route("/administration-utilisateur/{id}", name: "user_gestion")]
    public function userGestion(int $id, ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $userForm = $this->createForm(UpdateUserFormType::class, $user);
        $userForm->remove("password")->add("roles", ChoiceType::class,[
            'choices' => [
                'user' => "ROLE_USER",
                'mj' => "ROLE_MASTER",
                'admin' => "ROLE_ADMIN",
                'desactiver' => "ROLE_DEACTIVATE",
            ],
            "data" => $user->getRoles()[0],
            "mapped" => false
        ]);
        $passwordForm = $this->createForm(ChangePasswordFormType::class);
        $passwordForm->remove("ancientPassword");
        if ($request->isMethod("post")) {

            if($request->request->has("update_user_form")){
                $userForm->handleRequest($request);
                if ($userForm->isSubmitted() && $userForm->isValid()) {
                    $user->setRoles($userForm->get("roles")->getData());
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash("success", "l'utilisateur n°".$user->getId()." a été mis a jour");
                    return $this->redirectToRoute("admin_user_list");
                }
            }
            else if($request->request->has("change_password_form")){
                $passwordForm->handleRequest($request);
                if ($passwordForm->isSubmitted()&& $passwordForm->isValid()) {
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $passwordForm->get("plainPassword")->getData()
                        )
                    );
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash("success", "le mot de passe de l'utilisateur n°".$user->getId()." a été mis a jour");
                    return $this->redirectToRoute("admin_user_list");
                }
                
                
            }
        }
        return $this->render("admin/user/user.html.twig", [
            "userForm" => $userForm->createView(),
            "passwordForm" => $passwordForm->createView()
        ]);
    }
}