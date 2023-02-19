<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Json;

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
    public function cartAction(): Response
    {
        $c = $this->repo->showCart();

        // return $this->json(['cart' => $c]);
        return $this->render('cart/index.html.twig', [
            'carts' => $c
        ]);
    }

    /**
     * @Route("/cart/delete",name="deleteCart")
     */

    public function deleteCartAction(Cart $c, ManagerRegistry $reg): Response
    {
        $entityManager = $reg->getManager();

        $user = $this->getUser();
        $cart = $entityManager->getRepository(Cart::class)->removeCart($c, $user);

        // $entityManager->remove($cart);
        // $entityManager->flush();

        // $this->addFlash(
        //     'success',
        //     'A product was deleted'
        // );

        // $c = $this->repo->showCart();

        return $this->json($cart);
        return $this->render('cart/index.html.twig', [
            'carts' => $c
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

}
