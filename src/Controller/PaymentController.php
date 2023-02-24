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
        $orderForm = $this->createForm(OrderType::class, $p, [
            'action' => $this->generateUrl('addOrder')
        ]);

        $u = $this->getUser();
        $products = $repoCart->showCart($u);
        $user = $repoUser->find($u);

        return $this->render('payment/index.html.twig', [
            // Display product and Calculate the total price
            'products' => $products,
            // Display customer's infomation to set into Order
            'user' => $user,
            'orderForm' => $orderForm->createView()
        ]);

        return $this->json($products);
    }

    /**
     * @Route("/order", name="addOrder", methods={"POST"})
     */
    public function orderAction(Request $req, ManagerRegistry $reg): Response
    {
        $o = new Order();
        $orderForm = $this->createForm(OrderType::class, $o);

        $orderForm->handleRequest($req);
        $entity = $reg->getManager();

        $data = $orderForm->getData($req);

        $user = $this->getUser();

        $o->setDate(new \DateTime());
        $o->setTotal($data->getTotal());
        $o->setDeliveryLocal($data->getDeliveryLocal());
        $o->setStatus($data->isStatus());
        $o->setVoucher($data->getVoucher());
        $o->setUsername($user);
        $o->setCusName($data->getCusName());
        $o->setCusPhone($data->getCusPhone());

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entity->persist($o);
        // actually executes the queries (i.e. the INSERT query)
        $entity->flush();

        $this->addFlash(
            'success',
            'Order successully'
        );
        return $this->redirectToRoute("shoppingCart");
        // return $this->json($order);
    }
}
