<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="showProduct")
     */
    public function showProductAction(): Response
    {
        return $this->render('product/show.html.twig');
    }

    /**
     * @Route("/detail", name="proDetail_page")
     */
    public function productDetailAction(): Response
    {
        return $this->render('product/detail.html.twig');
    }
}
