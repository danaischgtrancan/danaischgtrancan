<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo=$repo;
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction(): Response
    {
        $products = $this->repo->findAll();
        return $this->render('home.html.twig',['prodcuts'=>$products]);
    }

    /**
     * @Route("/admin", name="adminPage")
     */
    public function adminPageAction(): Response
    {
        return $this->render('admin.html.twig', []);
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



   
}
