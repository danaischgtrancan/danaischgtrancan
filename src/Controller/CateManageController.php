<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CateManageController extends AbstractController
{
    #[Route('/cate/manage', name: 'app_cate_manage')]
    public function index(): Response
    {
        return $this->render('cate_manage/index.html.twig', [
            'controller_name' => 'CateManageController',
        ]);
    }
}
