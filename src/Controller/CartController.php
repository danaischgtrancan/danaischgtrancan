<?php

namespace App\Controller;

use App\Entity\Cart;
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
    // Create a new one
    /**
     * @Route("/add", name="addCart", methods={"POST"})
     */
    public function addAction(Request $req, ProductRepository $repoPro): Response
    {
        // Khi up hinh len khong phai la kieu chuoi, do do minh can dung k  ieu mix
        $s = new Cart();
        // Call function above
        $req = $this->transformJsonBody($req);

        // Defination name and importer
        // Luu y rang neu parameter giua clien va server khong khop nhau, chuong trinh se ngung hoat dong
        $id = $req->get('id');
        $product = $repoPro->find($id);
        $s->setProduct($product);
        $user = $this->getUser();
        //$userId = $this->repo->findOneBy(['user'=> $user]);
        $s->setUser($user);
        $count = $req->get('count');
        $s->setCount($count);

        $this->repo->save($s, true);

        $this->addFlash(
            'success',
            'A product was added'
        );

        $carts = $this->repo->showCart($user);
        return $this->render('cart/index.html.twig', [
            'carts' => $carts
        ]);
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

    /**
     * @Route("/delete/{id}", name="deleteCart", methods={"delete"})
     */

    public function deleteCartAction(Cart $c): Response
    {

        // $entityManager = $reg->getManager();

        // $user = $this->getUser();

        $$this->repo->remove($c, true);
        // $entityManager->flush();

        // $c = $this->repo->showCart();

        return $this->json($c);
        // return $this->render('cart/index.html.twig', [
        //     'carts' => $c
        // ]);
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
