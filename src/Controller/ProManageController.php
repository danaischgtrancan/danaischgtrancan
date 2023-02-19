<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Common\Proxy\Proxy;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/product")
 */

class ProManageController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    // Show 
    /**
     * @Route("/", name="pro_page")
     */
    public function productMangeAction(): Response
    {
        $p = new Product();
        // $productForm = $this->createForm(ProductType::class, $p);

        $products = $this->repo->findBy([], [
            'id' => 'DESC'
        ]);

        // Return many element
        $data = [];
        foreach ($products as $p) :
            // Chỉ định cụ thể supplier để tránh liên kết vòng trong bản CarSup (PK)
            $data[] = [
                'id' => $p->getId(),
                'name' => $p->getName(),
                'status' => $p->isStatus(),
                'descriptions' => $p->getDescriptions(),
                'price' => $p->getPrice(),
                'forGender' => $p->isForGender(),
                'category' => $p->getCategory(),
                'supplier' => $p->getSupplier(),
                'image' => $p->getImage(),

            ];
        endforeach;

        // return $this->json($data);

        return $this->render('pro_manage/index.html.twig', [
            'products' => $data
        ]);
    }

    // Add 
    /**
     * @Route("/create", name="addPro_page")
     */
    public function createAction(Request $req, SluggerInterface $slugger, ManagerRegistry $reg): Response
    {
        $p = new Product();
        $productForm = $this->createForm(ProductType::class, $p);

        $productForm->handleRequest($req);
        $entity = $reg->getManager();

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $data = $productForm->getData($req);
            $p->setName($data->getName());
            $p->setDescriptions($data->getDescriptions());
            $p->setPrice($data->getPrice());
            $p->setStatus($data->isStatus());
            $p->setImage($data->getImage());
            $p->setForGender($data->isForGender());
            $p->setCategory($data->getCategory());
            $p->setSupplier($data->getSupplier());

            $imgFile = $productForm->get('image')->getData();

            if ($imgFile && $imgFile != "") :
                // Rename File Imange
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                //  SluggerInterface $slugger
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
            endif;

            // Services: thiết lập biến mt
            try {
                $imgFile->move(
                    $this->getParameter('image_dir'),
                    $newFilename
                );
            } catch (FileException $th) {
                echo $th;
            }

            $p->setImage($newFilename);
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entity->persist($p);
            // actually executes the queries (i.e. the INSERT query)
            $entity->flush();

            $this->addFlash(
                'success',
                'New products have been added'
            );
            return $this->redirectToRoute("pro_page");
        }

        return $this->render('pro_manage/new.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    public function uploadImage($imgFile, SluggerInterface $slugger): ?string
    {
        $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
        try {
            $imgFile->move(
                $this->getParameter('image_dir'),
                $newFilename
            );
        } catch (FileException $e) {
            echo $e;
        }
        return $newFilename;
    }

    // Update 
    /**
     * @Route("/edit/{id}", name="editPro_page")
     */

    public function editAction(Request $req, SluggerInterface $slugger, ManagerRegistry $reg, Product $p): Response
    {
        $entityManager = $reg->getManager();
        $product = $entityManager->getRepository(Product::class)->find($p);

        $productForm = $this->createForm(ProductType::class);
        $productForm->handleRequest($req);
        // $entity = $reg->getManager();

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $data = $productForm->getData($req);
            $p->setName($data->getName());
            $p->setDescriptions($data->getDescriptions());
            $p->setPrice($data->getPrice());
            $p->setStatus($data->isStatus());
            $p->setImage($data->getImage());
            $p->setForGender($data->isForGender());
            $p->setCategory($data->getCategory());
            $p->setSupplier($data->getSupplier());

            $imgFile = $productForm->get('image')->getData();

            if ($imgFile && $imgFile != "") :
                // Rename File Imange
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                //  SluggerInterface $slugger
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
            endif;

            try {
                $imgFile->move(
                    $this->getParameter('image_dir'),
                    $newFilename
                );
            } catch (FileException $th) {
                echo $th;
            }
            $p->setImage($newFilename);
            // $entity->persist($p);
            // $entity->flush();

            $this->addFlash(
                'success',
                'New products was added'
            );
            return $this->redirectToRoute("pro_page");
        }

        return $this->render('pro_manage/new.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    // Delete
    /**
     * @Route("/delete/{id}", name="deletePro_page")
     */
    public function deleteAction(Product $p, ManagerRegistry $reg)
    {
        $entityManager = $reg->getManager();
        $product = $entityManager->getRepository(Product::class)->find($p);

        $entityManager->remove($product);
        $entityManager->flush();

        $products = $this->repo->findBy([], [
            'id' => 'DESC'
        ]);

        $this->addFlash(
            'success',
            'A products was deleted'
        );

        return $this->render('pro_manage/index.html.twig', [
            'products' => $products
        ]);
    }
}
