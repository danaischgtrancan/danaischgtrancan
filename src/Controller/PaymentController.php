<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use App\Form\OrderType;
use App\Repository\CartRepository;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ProSizeRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    private OrderRepository $repo;
    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

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
    public function orderAction(
        Request $req,
        ManagerRegistry $reg,
        CartRepository $repoCart,
        ProductRepository $repoPro,
        OrderDetailRepository $repoOd
    ): Response {
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

        // Save Order Detail

        // It returns two-dimensional array
        $products = $repoCart->getCartOfCurrentUser($user);

        foreach ($products as $product) :
            $orderDetail = new OrderDetail();
            // Find object Product
            $p = $repoPro->find($product['proId']);
            $orderDetail->setProducts($p);
            $orderDetail->setQuantity($product['qty']);
            $orderDetail->setOrders($o);

            $repoOd->save($orderDetail, true);

            // Update quantity in Stock
            

        endforeach;


        // Delete Cart
        $cartId = $repoCart->findUser($user);

        $entity = $reg->getManager();
        foreach ($cartId as $c) :
            $cart = $repoCart->find($c['cartId']);
            $entity->remove($cart, true);
            $entity->flush();
        endforeach;

        // $this->addFlash(
        //     'success',
        //     'Order successully'
        // );
        return $this->redirectToRoute("shoppingCart");
        // return $this->json($cart);
    }
}
