<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProSize;
use App\Form\ProSizeType;
use App\Repository\ProductRepository;
use App\Repository\ProSizeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/size")
 */
class ProSizeController extends AbstractController
{
    private ProSizeRepository $repo;
    public function __construct(ProSizeRepository $repo)
    {
        $this->repo = $repo;
    }

    //  Show size a product

    /**
     * @Route("/{id}", name="size_page")
     */
    public function sizeMangeAction(Product $productId, ProductRepository $repoPro): Response
    {
        $sizes = $this->repo->findSize([$productId]);
        $p = $productId->getId();
        // return $this->json($proID);
        return $this->render('prosize_manage/index.html.twig', [
            'sizes' => $sizes,
            'proID' => $p
        ]);
    }

    // Add new size in Size

    /**
     * @Route("/create/{id}", name="addSize_page")
     */
    public function createAction(Request $req, int $id, ManagerRegistry $reg, ProductRepository $repoPro): Response
    {
        $p = new ProSize();
        $proSizeForm = $this->createForm(ProSizeType::class, $p);

        $proSizeForm->handleRequest($req);
        $entity = $reg->getManager();

        // choose the newest product
        $pro = $repoPro->find($id);

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
}
