<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set('Asia/Ho_Chi_Minh');

/**
 * @Route("/admin/order")
 */
class OrderManageController extends AbstractController
{
    private OrderRepository $repo;
    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="order_page")
     */
    public function orderAction(): Response
    {
        $orders = $this->repo->findBy([], [
            'id' => 'DESC'
        ]);

        return $this->render('order_manage/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/changeConfirm/{id}", name="change_page")
     */
    public function changeAction(int $id, ManagerRegistry $reg): Response
    {
        $orders = $this->repo->find($id);
        $orders->setStatus(1);
        $entity = $reg->getManager();

        $entity->persist($orders);
        $entity->flush();

        return $this->redirectToRoute('order_page');
    }
}
