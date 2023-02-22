<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment_page", methods={"POST"})
     */
    public function paymentAction(CartRepository $repoCart): Response
    {

        $user = $this->getUser();
        $products = $repoCart->findByUser($user);

        return $this->render('payment/index.html.twig', [
            'products' => $products,
        ]);
    }
}
