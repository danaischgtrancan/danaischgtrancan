<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProSup;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdministrationController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    // /**
    //  * @Route("/product", name="product_show")
    //  */
    // public function readAllAction(): Response
    // {
    //     $products = $this->repo->findAll();
    //     return $this->render('product/index.html.twig', [
    //         'products' => $products
    //     ]);
    // }


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

    
}
