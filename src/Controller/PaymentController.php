<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment_page", methods={"POST"})
     */
    public function paymentAction(CartRepository $repoCart, UserRepository $repoUser): Response
    {

        $u = $this->getUser();
        $products = $repoCart->showCart($u);
        $user = $repoUser->find($u);

        return $this->render('payment/index.html.twig', [
            'products' => $products,
            'user' => $user
        ]);

        // return $this->json($products);
    }

    /**
     * @Route("/payment", name="addOrder", methods={"POST"})
     */
    public function orderAction(): Response
    {

        $u = $this->getUser();
        $products = $repoCart->showCart($u);
        $user = $repoUser->find($u);

        return $this->render('payment/index.html.twig', [
            'products' => $products,
            'user' => $user
        ]);
    }
}
