<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    private CategoryRepository $repo;
    public function __construct(CategoryRepository $repo)
   {
      $this->repo = $repo;
   }
    /**
     * @Route("/", name="category_show")
     */
    public function readAllAction(): Response
    {
        $c = $this->repo->findAll();
        return $this->render('category/index.html.twig', [
            'category'=>$c
        ]);
    }

     /**
     * @Route("/{id}", name="category_read",requirements={"id"="\d+"})
     */
    public function showAction(Category $c): Response
    {
        return $this->render('category/index.html.twig', [
            'c'=>$c
        ]);
    }

    /**
     * @Route("/add", name="category_create")
     */
    public function createAction(Request $req, SluggerInterface $slugger, CategoryRepository $repo): Response
    {
        
        $c = new Category();
        $form = $this->createForm(CategoryType::class, $c);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            
            $repo->save($c,true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("cate_manage/index.html.twig",[
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/edit/{id}", name="category_edit")
     */
    public function editAction(Request $req, SluggerInterface $slugger, CategoryRepository $repo, Category $c): Response
    {
        $form = $this->createForm(CategoryType::class, $c);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            
            $repo->save($c,true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("cate_manage/index.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     *  @Route("/delete/{id}", name="category_delete", requirements={"id"="\d+"})
     */
    public function deleteAction(Request $req, Category $c): Response
    {
        $this->repo->remove($c,true);
        return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
    }
}
