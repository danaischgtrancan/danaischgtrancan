<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\SizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function showProductAction(Request $req): Response
    {
        $title = "Not Found";

        $sort_by = $req->query->get('sort_by');
        $order = $req->query->get('order');
        if (isset($sort_by)) :
            if ($sort_by == 'name') :
                $products = $this->repo->findByName($order);
                $title = "Sort by name";
            endif;
            if ($sort_by == 'price') :  
                $products = $this->repo->findByPrice($order);
                $title = "Sort by price";
            endif;
            if ($sort_by == 'category') :
                $products = $this->repo->findByCate($order);
                $title = "Sort by categpory";
            endif;
            if ($sort_by == 'supplier') :
                $products = $this->repo->findBySupp($order);
                $title = "Sort by supplier";
            endif;
            if ($sort_by == 'gender') :
                if ($order == "men") :
                    $products = $this->repo->findByGender(0);
                    $title = "Sort by Men's clothing";
                else :
                    $products = $this->repo->findByGender(1);
                    $title = "Sort by Women's clothing";
                endif;
            endif;
        else :
            $products = $this->repo->findAll();
            $title = "All product";
        endif;

        $catefories = $this->repo->findCategory();
        $suppliers = $this->repo->findSupplier();

        // return $this->json(['products' => $products]);
        return $this->render('product/show.html.twig', [
            'products' => $products,
            'catefories' => $catefories,
            'suppliers' => $suppliers,
            'title' => $title
        ]);
    }

    /**
     * @Route("/detail/{id}", name="proDetail_page")
     */
    public function productDetailAction(int $id, SizeRepository $repoSize): Response
    {
        $product = $this->repo->findOnePro($id);
        $size = $repoSize->findSize();


        // return $this->json(['size' => $size]);

        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'size' => $size
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
}
