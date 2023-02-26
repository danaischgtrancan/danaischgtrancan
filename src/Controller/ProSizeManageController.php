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

    //  Show specific size of a product

    /**
     * @Route("/{id}", name="proSize_page")
     */
    public function sizeMangeAction(Product $productId, ProductRepository $repoPro, ManagerRegistry $reg): Response
    {
        $sizes = $this->repo->findSize([$productId]);
        return $this->render('prosize_manage/index.html.twig', [
            'sizes' => $sizes,
            'proName' => $productId->getName(),
            'proID' => $productId->getId()
        ]);
    }

    // Add new size in Size
    /**
     * @Route("/create/{id}", name="addProSize_page")
     */
    public function createAction(Product $pro, Request $req, ManagerRegistry $reg, ProductRepository $repoPro): Response
    {
        $p = new ProSize();
        $proSizeForm = $this->createForm(ProSizeType::class, $p);

        $proSizeForm->handleRequest($req);
        $entity = $reg->getManager();

        if ($proSizeForm->isSubmitted() && $proSizeForm->isValid()) {
            $data = $proSizeForm->getData($req);
            $pro_id = $req->request->get("proId");
            $obj = $repoPro->find($pro_id);
            // return $this->json($data);
            $sizeAlreadyExistsOrNot = $this->repo->findOneBy(['size' => $data->getSize()]);
            if ($sizeAlreadyExistsOrNot == null) :
                $p->setProduct($obj);
                $p->setSize($data->getSize());
                $p->setQuantity($data->getQuantity());
                $entity->persist($p);
            else :
                $sizeAlreadyExistsOrNot->setQuantity($sizeAlreadyExistsOrNot->getQuantity() + $data->getQuantity());
                $entity->persist($sizeAlreadyExistsOrNot);
            endif;
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            $this->addFlash(
                'success',
                'Added successfully'
            );
            return $this->redirectToRoute("proSize_page", ['id' => $pro->getId()]);
        }

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
