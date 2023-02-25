<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    private CartRepository $repo;
    public function __construct(CartRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="shoppingCart")
     */
    public function cartAction(): Response
    {
        $user = $this->getUser();
        $carts = $this->repo->showCart($user);

        return $this->render('cart/index.html.twig', [
            'carts' => $carts
        ]);
    }

    // Create a new one
    /**
     * @Route("/add", name="addCart", methods={"POST"})
     */
    public function addAction(Request $req, ProductRepository $repoPro): Response
    {
        // Call function above
        $user = $this->getUser();
        $req = $this->transformJsonBody($req);
        $id = $req->get('id');
        $product = $repoPro->find($id);
        $count = $req->get('count');

        // Query to  find $product of this user exists or not
        //It returns an array with only one line (index: 0)
        $findCart = $this->repo->findByProId($product, $user);

        // If its not exists, add new
        if ($findCart == null) :
            $newCart = new Cart();
            $newCart->setProduct($product);
            $newCart->setUser($user);
            $newCart->setCount($count);

            $this->repo->save($newCart, true);
        else :
            // It exists update Count
            // Create $cart to find product object that match with $product and $user below to update Count
            $cart = $this->repo->find($findCart[0]);
            $cart->setCount($cart->getCount() + $count);

            $this->repo->save($cart, true);
        endif;
        return new JsonResponse();
    }

    public function transformJsonBody(Request $re)
    {
        $data = json_decode($re->getContent(), true);
        if ($data === null) {
            return $re;
        }
        $re->request->replace($data);
        return $re;
    }


    /**
     * @Route("/delete/{id}", name="deleteCart", methods={"DELETE"})
     */
    public function deleteCartAction(int $id, ManagerRegistry $reg, ProductRepository $repoPro): Response
    {
        $user = $this->getUser();
        $cart = $this->repo->removeCart($id, $user);

        $entity = $reg->getManager();
        foreach ($cart as $c) :
            $entity->remove($c);
            $entity->flush();
        endforeach;

        return $this->json("Success");
        // return new JsonResponse();
        // return $this->redirectToRoute('shoppingCart');
    }


    // Chang number in Cart
    /**
     * @Route("/change", name="change", methods={"POST"})
     */
    public function minus(Request $req, ManagerRegistry $reg, ProductRepository $repoPro): Response
    {
        $cartId = $req->request->get('cartId');
        $user = $this->getUser();
        $action = $req->request->get('action');

        $entity = $reg->getManager();
        $cart = $this->repo->find($cartId);

        if($action == "minus"):
            $cart->setCount($cart->getCount() - 1);
        else:
            $cart->setCount($cart->getCount() + 1);
        endif;
        
        $entity->persist($cart);
        $entity->flush();

        // $entity = $reg->getManager();
        // if ($action == "minus") :
        //     foreach ($cart as $c) :
        //         $c->setCount($qty - 1);
        //         $entity->persist($c);
        //         $entity->flush();
        //     endforeach;
        // endif;

        // return $this->json(['cart' => $cart]);
        return $this->redirectToRoute('shoppingCart');
    }
}
