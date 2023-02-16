<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistationController extends AbstractController
{
    /**
     * @Route("/signIn", name="signIn_page")
     */
    public function signInAction(): Response
    {
        return $this->render('registation/signIn.html.twig', [
            'controller_name' => 'RegistationController',
        ]);
    }

    /**
     * @Route("/logout", name="logout_page")
     */
    public function logOutAction(): Response
    {
        return $this->render('registation/login.html.twig');
    }
}
