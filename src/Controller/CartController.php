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
        $user = $this->getUser();

        $carts = new Cart();
        // Call function above
        $req = $this->transformJsonBody($req);

        // Defination name and importer
        // Luu y rang neu parameter giua clien va server khong khop nhau, chuong trinh se ngung hoat dong
        $id = $req->get('id');
        $product = $repoPro->find($id);


        $count = $req->get('count');
        $carts->setCount($count);


        // Check quantity of Stock
        foreach ($product as $p) :
            if ($count - $p->getq() < 0) :

            endif;
        endforeach;
        $carts->setProduct($product);
        $carts->setUser($user);

        $this->repo->save($carts, true);
        return $this->json($carts);
        // return new JsonResponse();
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
     * @Route("/delete/{id}", name="deleteCart", methods={"delete"})
     */
    public function deleteCartAction(int $id, ManagerRegistry $reg): Response
    {
        $user = $this->getUser();
        $cart = $this->repo->removeCart($id, $user);
        
        $entity = $reg->getManager();
        foreach ($cart as $c) :
            $entity->remove($c, true);
            $entity->flush();
        endforeach;

        return $this->json($cart);
        // return new JsonResponse();
        // return $this->redirectToRoute('shoppingCart');
    }


    // Chang number in Cart
    /**
     * @Route("/onchange/{id}", name="onchange_event")
     */
    public function upDown(Product $p): Response
    {
        $user = $this->getUser();
        $product = $this->repo->findByProId($p->getId(), $user);
        foreach ($product as $p) :
            $p->setCount($p->getCount() + 1);
            break;
        endforeach;
        // return $this->json(['product' => $product]);
        return $this->redirectToRoute('shoppingCart');
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
