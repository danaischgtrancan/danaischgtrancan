<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/product", name="showProduct")
     */
    public function showProductAction(): Response
    {
        return $this->render('product/show.html.twig');
    }

    /**
     * @Route("/sale", name="saleProduct")
     */
    public function saleProductAction(): Response
    {
        return $this->render('product/sale.html.twig');
    }

    /**
     * @Route("/delivery", name="saleProduct")
     */
    public function deliveryAction(): Response
    {
        return $this->render('product/sale.html.twig');
    }
    
     /**
     * @Route("/danaischgStore", name="aboutUs")
     */
    public function aboutUsAction(): Response
    {
        return $this->render('product/sale.html.twig');
    }

     /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(): Response
    {
        return $this->render('admin.html.twig');
    }

    /**
     * @Route("/order", name="order")
     */
    public function orderAction(): Response
    {
        return $this->render('admin/order.html.twig');
    }

    /**
     * @Route("/category", name="category")
     */
    public function categoryAction(): Response
    {
        return $this->render('admin/category.html.twig');
    }

    /**
     * @Route("/supplier", name="supplier")
     */
    public function supplierAction(): Response
    {
        return $this->render('admin/supplier.html.twig');
    }

    /**
     * @Route("/product", name="product")
     */
    public function productAction(): Response
    {
        return $this->render('admin/product.html.twig');
    }
}
