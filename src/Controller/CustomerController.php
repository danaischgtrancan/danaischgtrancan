<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
     /**
     * @Route("/customer", name="cus_profile")
     */
    public function cusAction(): Response
    { 
        $user = $this->getUser();
        return $this->render('customer/index.html.twig', [
            'username' => 'Your username',
            'email' => 'Your email',
        ]);
    }
}
