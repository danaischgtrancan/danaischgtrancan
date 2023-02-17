<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        return $this->render('detail.html.twig', [
            'c'=>$c
        ]);
    }

     /**
     * @Route("/add", name="category_create")
     */
    public function createAction(Request $req, SluggerInterface $slugger): Response
    {
        
        $c = new Category();
        $form = $this->createForm(CategoryType::class, $c);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            
            $this->repo->save($c,true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("admin/category.html.twig",[
            'form' => $form->createView()
        ]);
    }

         /**
     * @Route("/edit", name="category_edit",requirements={"id"="\d+"})
     */
    public function editAction(Request $req, SluggerInterface $slugger): Response
    {
        $c = new Category();
        $form = $this->createForm(CategoryType::class, $c);   

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $this->repo->save($c,true);
            return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("admin/category.html.twig",[
            'form' => $form->createView()
        ]);
    }




    /**
     * @Route("/delete",name="category_delete",requirements={"id"="\d+"})
     */
    
     public function deleteAction(Request $req, Category $c): Response
     {
        $c = new Category();
         $this->repo->remove($c,true);
         return $this->redirectToRoute('category_show', [], Response::HTTP_SEE_OTHER);
     }
 







   
}
