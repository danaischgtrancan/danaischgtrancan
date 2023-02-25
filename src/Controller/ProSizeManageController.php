<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProSize;
use App\Entity\Size;
use App\Form\ProSizeType;
use App\Repository\ProductRepository;
use App\Repository\ProSizeRepository;
use App\Repository\SizeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/prosize")
 */
class ProSizeManageController extends AbstractController
{
    private ProSizeRepository $repo;
    public function __construct(ProSizeRepository $repo)
    {
        $this->repo = $repo;
    }

    //  Show size a product

    /**
     * @Route("/{id}", name="proSize_page")
     */
    public function sizeMangeAction(Product $productId, ProductRepository $repoPro, ManagerRegistry $reg): Response
    {
        $sizes = $this->repo->findSize([$productId]);
        $pro = $reg->getRepository(Product::class)->find($productId);
        // return $this->json($pro->getName());
        return $this->render('prosize_manage/index.html.twig', [
            'sizes' => $sizes,
            'proName' => $pro->getName(),
            'proID' => $pro->getId()
        ]);
    }

    // Add new size in Size
    /**
     * @Route("/create/{id}", name="addProSize_page")
     */
    public function createAction(Request $req, Product $pro, ManagerRegistry $reg, ProductRepository $repoPro): Response
    {
        $p = new ProSize();
        $proSizeForm = $this->createForm(ProSizeType::class, $p);

        $proSizeForm->handleRequest($req);
        $entity = $reg->getManager();

        // choose the newest product

        if ($proSizeForm->isSubmitted() && $proSizeForm->isValid()) {
            $data = $proSizeForm->getData($req);

            $p->setProduct($pro);
            $p->setSize($data->getSize());
            $p->setQuantity($data->getQuantity());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entity->persist($p);
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            $this->addFlash(
                'success',
                'A products was added'
            );
            return $this->redirectToRoute("pro_page");
        }

        // return $this->json($id);

        return $this->render('prosize_manage/new.html.twig', [
            'proSizeForm' => $proSizeForm->createView(),
            // Get name to display default value
            'proName' => $pro->getName(),
            // Get id to save defalt value into ProSize
            'proId' => $pro->getId()
        ]);
    }
    /**
     * @Route("/edit/{id}", name="editProSize_page")
     */
    public function editSizeAction(Request $req, ProSize $ps, ManagerRegistry $reg): Response
    {
        $p = new ProSize();
        $proSizeForm = $this->createForm(ProSizeType::class, $p);

        $proSizeForm->handleRequest($req);
        $entity = $reg->getManager();

        if ($proSizeForm->isSubmitted() && $proSizeForm->isValid()) {
            $data = $proSizeForm->getData($req);

            // $ps = $this->repo->findOneBy(['product' => $pro, 'size' => $data->getSize()]);

            $ps->setQuantity($data->getQuantity());

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entity->persist($p);
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            $this->addFlash(
                'success',
                'A size was updated'
            );
            return $this->redirectToRoute("proSize_page", [
                'id' => $ps->getProduct()->getId()
            ]);
            // return $this->json($data);
        }

        // return $this->json($sizeId);
        return $this->render('prosize_manage/edit.html.twig', [
            'proSizeForm' => $proSizeForm->createView(),
            // Get name to display default value
            'sizeName' => $ps->getSize()->getName(),
            'proName' => $ps->getProduct()->getName()
        ]);
    }


    /* ==========================================================================
   Delete Admin Product Page
   ========================================================================== */

    /**
     * @Route("/delete/{id}", name="deletePro_page", methods={"delete"})
     */
    public function deleteProSizeAction(ProSize $ps)
    {
        $this->repo->remove($ps, true);
        return new JsonResponse();
    }
}
