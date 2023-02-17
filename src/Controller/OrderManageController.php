<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderManageController extends AbstractController
{
    #[Route('/order/manage', name: 'app_order_manage')]
    public function index(): Response
    {
        return $this->render('order_manage/index.html.twig', [
            'controller_name' => 'OrderManageController',
        ]);
    }
}
