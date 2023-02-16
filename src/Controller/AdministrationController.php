<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{


    /**
     * @Route("/order", name="order_page")
     */
    public function orderAction(): Response
    {
        return $this->render('admin/order.html.twig');
    }

    /**
     * @Route("/category", name="cate_page")
     */
    public function categoryAction(): Response  
    {
        return $this->render('admin/category.html.twig');
    }

    /**
     * @Route("/supplier", name="supp_page")
     */
    public function supplierAction(): Response
    {
        return $this->render('admin/supplier.html.twig');
    }

    /**
     * @Route("/productManagement", name="pro_page")
     */
    public function productAction(): Response
    {
        return $this->render('admin/product.html.twig');
    }
}
