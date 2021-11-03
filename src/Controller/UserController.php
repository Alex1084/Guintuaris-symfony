<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * permet de voir les information de son profil
     * @Route("/profil/{id}", name="profil")
     */
    public function profilUser(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }
}
