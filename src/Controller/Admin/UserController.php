<?php

namespace App\Controller\Admin;

use App\Form\ChangePasswordFormType;
use App\Form\UpdateUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/administration/utilisateur", name:"admin_")]
class UserController extends AbstractController
{
    #[Route('/liste', name: 'user_list')]
    public function userlist(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user/userList.html.twig', [
            "users" => $users
        ]);
    }

    #[Route("/{id}", name: "user_gestion")]
    public function userGestion(
        int $id,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $userRepository->find($id);
        $userForm = $this->createForm(UpdateUserFormType::class, $user);
        $userForm->remove("password")->add("roles", ChoiceType::class,[
            'choices' => [
                'Utilisateur' => "ROLE_USER",
                'Premium' => "ROLE_PREMIUM",
                'Maitre du jeu' => "ROLE_MASTER",
                'Administrateur' => "ROLE_ADMIN",
                'Désactiver se compte' => "ROLE_DEACTIVATE",
            ],
            "attr" => ["class" => "log"],
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
                    $this->addFlash("success", "L'utilisateur n°".$user->getId()." a été mis à jour.");
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
                    $this->addFlash("success", "Le mot de passe de l'utilisateur n°".$user->getId()." a été mis à jour.");
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
