<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }
}
