<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuppManageController extends AbstractController
{
    #[Route('/supp/manage', name: 'app_supp_manage')]
    public function index(): Response
    {
        return $this->render('supp_manage/index.html.twig', [
            'controller_name' => 'SuppManageController',
        ]);
    }
}
