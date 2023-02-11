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
     * @Route("/product", name="product")
     */
    public function productAction(): Response
    {
        return $this->render('admin/product.html.twig');
    }
}
