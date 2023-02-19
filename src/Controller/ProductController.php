<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/", name="showProduct")
     */
    public function showProductAction(): Response
    {
        $products = $this->repo->findAll();
        $catefories = $this->repo->findCategory();

        // return $this->json(['products' => $products]);
        return $this->render('product/show.html.twig', [
            'products' => $products,
            'catefories' => $catefories
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

    /**
     * @Route("/search", name="searchPro_page")
     */
    public function searchProductAction(string $search): Response
    {
        $products = $this->repo->findByName($search);

        return $this->render('product/show.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/{value}", name="sortByName_page")
     */
    public function sortByNameAction(string $value): Response
    {
        $products = $this->repo->sortByName($value);
        $catefories = $this->repo->findCategory();

        return $this->render('product/show.html.twig', [
            'products' => $products,
            'catefories' => $catefories
        ]);
    }
}
