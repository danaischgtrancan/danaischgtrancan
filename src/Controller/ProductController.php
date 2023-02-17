<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/product", name="showProduct")
     */
    public function showProductAction(): Response
    {

        $products = $this->repo->findAll();
        return $this->json($products);
        // return $this->render('product/show.html.twig');
    }

    /**
     * @Route("/detail", name="proDetail_page")
     */
    public function productDetailAction(): Response
    {
        return $this->render('product/detail.html.twig');
    }
}
