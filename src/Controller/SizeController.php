<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProSize;
use App\Repository\ProSizeRepository;
use App\Repository\SizeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/size")
 */

class SizeController extends AbstractController
{
    private SizeRepository $repo;
    public function __construct(SizeRepository $repo)
    {
        $this->repo = $repo;
    }

    //  Show size a product

    /**
     * @Route("/{id}", name="size_page")
     */
    public function sizeMangeAction(Product $productId): Response
    {
        $sizes = $this->repo->findSize([$productId]);

        // return $this->json(['sizes' => $sizes]);
        return $this->render('size_manage/index.html.twig', [
            'sizes' => $sizes
        ]);
    }

    // Create one

    /**
     * @Route("/size/{id}", name="addSize_page")
     */
    public function addSizeAction(Request $req, ManagerRegistry $reg, Product $p): Response
    {
        $ps = new ProSize();
        $proSizeForm = $this->createForm(ProSizeType::class, $ps);


        $product = $req->get('productId');
        $size = $req->get('sizeId');

        $proSizeForm->handleRequest($req);
        $entity = $reg->getManager();

        if ($proSizeForm->isSubmitted() && $proSizeForm->isValid()) {
            $data = $proSizeForm->getData($req);
            $ps->setProduct($data->getProduct());
            $ps->setSize($data->getSize());
            $ps->setQuantity($data->getQuantity());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entity->persist($ps);
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            $this->addFlash(
                'success',
                'A products size was added'
            );
            return $this->redirectToRoute("size_page", [
                'product' => $product
            ]);
        }

        return $this->render('size/index.html.twig', [
            'proSizeForm' => $proSizeForm->createView(),
            'product' => $product,
            'size' => $size
        ]);
    }


    /* ==========================================================================
   Update Admin Product Size Page
   ========================================================================== */

    /**
     * @Route("/edit/{id}", name="editSize_page")
     */

    public function editSizeAction(Request $req, ManagerRegistry $reg, int $id, ProSizeRepository $repoProSize): Response
    {
        // pz will return an array
        $pId = $this->$req->get('productId');
        // $sId = $this->$req->get('sizeId');
        // $sName = $this->$req->get('sizeName');

        // $ps = $repoProSize->find($pId);

        // $entity = $reg->getManager();

        // $proSizeForm = $this->createForm(ProSizeType::class, $pz);
        // $proSizeForm->handleRequest($req);

        // if ($proSizeForm->isSubmitted() && $proSizeForm->isValid()) {
        //     $data = $proSizeForm->getData($req);

        //     $pro_id = $req->request->get('pro_id');
        //     $product = $this->repo->find($pro_id);

        //     $proSize = new ProSize();

        //     $proSize->setProduct($product);
        //     $proSize->setSize($data->getSize());
        //     $proSize->setQuantity($data->getQuantity());

        //     $entity->persist($proSize);
        //     $entity->flush();

        //     $this->addFlash(
        //         'success',
        //         'New products was updated'
        //     );
        //     return $this->redirectToRoute("pro_page");
        // }
        return $this->json(['ps' => $pId]);
        // return $this->render('size/edit.html.twig', [
        //     'size' => $ps,
        //     'proSizeForm' => $proSizeForm->createView()
        // ]);
    }
}
