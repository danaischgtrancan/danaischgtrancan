<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/product")
 */

class ProManageController extends AbstractController
{
    private ProductRepository $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @Route("/list", name="pro_page")
     */
    public function productMangeAction(): Response
    {
        $p = new Product();
        $productForm = $this->createForm(ProductType::class, $p);

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
            'products' => $data, 
            'productForm' => $productForm->createView()
        ]);
    }

    /**
     * @Route("/add", name="addPro")
     */
    public function createAction(Request $req, SluggerInterface $slugger): Response
    {

        $p = new Product();
        $productForm = $this->createForm(ProductType::class, $p);

        $productForm->handleRequest($req);
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $imgFile = $productForm->get('file')->getData();
            if ($imgFile) {
                $newFilename = $this->uploadImage($imgFile, $slugger);
                $p->setImage($newFilename);
            }
            $this->repo->save($p, true);
            // return $this->json($form);
            return $this->redirectToRoute('pro_show', [], Response::HTTP_SEE_OTHER);
        }
        // return $this->json($form);

        return $this->render("pro_manage/index.html.twig", [
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
}
