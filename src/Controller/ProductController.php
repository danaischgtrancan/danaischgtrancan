<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        // return $this->json(['products' => $products]);
        return $this->render('product/show.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/detail/{id}", name="proDetail_page")
     */
    public function productDetailAction(int $id): Response
    {
        $product = $this->repo->find($id);
        // return $this->json(['product' => $product]);
        
        return $this->render('product/detail.html.twig', [
            'product' => $product
        ]);
    }
}
