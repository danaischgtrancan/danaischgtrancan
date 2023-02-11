<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistationController extends AbstractController
{
    #[Route('/registation', name: 'app_registation')]
    public function index(): Response
    {
        return $this->render('registation/index.html.twig', [
            'controller_name' => 'RegistationController',
        ]);
    }
}
