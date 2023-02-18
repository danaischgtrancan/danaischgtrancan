<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CartController extends AbstractController
{
    private CartRepository $repo;
    public function __construct(CartRepository $repo)
   {
      $this->repo = $repo;
   }
    /**
     * @Route("/cart", name="shoppingCart")
     */
    public function readAllAction(): Response
    {
        $c = $this->repo->findAll();
        return $this->render('cart/index.html.twig', [
            // 'category'=>$c   
        ]);
    }


     /**
     * @Route("/cart", name="shoppingCart")
     */
    public function createAction(Request $req, SluggerInterface $slugger): Response
    {
        
        $c = new Cart();
        $form = $this->createForm(CartType::class, $c);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            
            $this->repo->save($c,true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("admin/category.html.twig",[
            'form' => $form->createView()
        ]);
    }

         /**
     * @Route("/edit", name="category_edit",requirements={"id"="\d+"})
     */
    // public function editAction(Request $req, SluggerInterface $slugger): Response
    // {
    //     $c = new Category();
    //     $form = $this->createForm(CategoryType::class, $c);   

    //     $form->handleRequest($req);
    //     if($form->isSubmitted() && $form->isValid()){

    //         $this->repo->save($c,true);
    //         return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
    //     }
    //     return $this->render("admin/category.html.twig",[
    //         'form' => $form->createView()
    //     ]);
    // }

    /**
     * @Route("/delete",name="category_delete",requirements={"id"="\d+"})
     */
    
    //  public function deleteAction(Request $req, Category $c): Response
    //  {
    //     $c = new Category();
    //      $this->repo->remove($c,true);
    //      return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
    //  }
}
