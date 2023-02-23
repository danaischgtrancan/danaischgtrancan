<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Form\OrderType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment_page", methods={"POST"})
     */
    public function paymentAction(CartRepository $repoCart, UserRepository $repoUser): Response
    {
        $p = new Order();
        $orderForm = $this->createForm(OrderType::class, $p);

        $u = $this->getUser();
        $products = $repoCart->showCart($u);
        $user = $repoUser->find($u);

        return $this->render('payment/index.html.twig', [
            'products' => $products,
            'user' => $user,
            'orderForm' => $orderForm->createView()
        ]);

        // return $this->json($products);
    }

    /**
     * @Route("/order", name="addOrder", methods={"POST"})
     */
    public function orderAction(Request $req, ManagerRegistry $reg): Response
    {
        $p = new Order();
        $productForm = $this->createForm(ProductType::class, $p);

        $productForm->handleRequest($req);
        $entity = $reg->getManager();

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $data = $productForm->getData($req);
            $p->setName($data->getName());
            $p->setDescriptions($data->getDescriptions());
            $p->setPrice($data->getPrice());
            $p->setStatus($data->isStatus());
            $p->setImage($data->getImage());
            $p->setForGender($data->isForGender());
            $p->setCategory($data->getCategory());
            $p->setSupplier($data->getSupplier());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entity->persist($p);
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            // $this->addFlash(
            //     'success',
            //     'A products was added'
            // );
            return $this->redirectToRoute("addSize_page");
        }

        return $this->render('pro_manage/new.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }
}
