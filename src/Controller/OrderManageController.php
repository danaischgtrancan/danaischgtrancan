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
        $p = new Order();
        // $productForm = $this->createForm(ProductType::class, $p);

        $orders = $this->repo->findBy([], [
            'id' => 'DESC'
        ]);

        // Return many element
        $data = [];
        foreach ($orders as $p) :
            // Chỉ định cụ thể supplier để tránh liên kết vòng trong bản CarSup (PK)
            $data[] = [
                'id' => $p->getId(),
                'voucher' => $p->getVoucher(),
                'status' => $p->isStatus(),
                'date' => $p->getDate(),
                'price' => $p->getTotal(),
                'percentDiscount' => $p->getPercentDiscount(),
                'deliveryLocal' => $p->getDeliveryLocal()
            ];
        endforeach;

        // return $this->json($data);

        return $this->render('order_manage/index.html.twig', [
            'orders' => $data,
            // 'productForm' => $productForm->createView()
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
