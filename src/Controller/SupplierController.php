<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/supplier")
 */
class SupplierController extends AbstractController
{
    // #[Route('/supplier', name: 'app_supplier')]
    // public function index(): Response
    // {
    //     return $this->render('supplier/index.html.twig', [
    //         'controller_name' => 'SupplierController',
    //     ]);
    // }
   


    private SupplierRepository $repo;
    public function __construct(SupplierRepository $repo)
    {
        $this->repo=$repo;
    }
    // Read All
    /**
     * @Route("/", name="supp_page", )
     */
    public function readAllAction(): Response
    {
    //  tìm hết nhưng xếp theo id giảm dần
       $sup = $this->repo->findBy([],['id'=>'DESC']);
       $data = [];
       foreach($sup as $s){
        $data[]= 
        [
        'id'=>$s->getId(), 
        'name'=>$s->getName(), 
        'phone'=>$s->getPhone(),
        'email'=>$s->getEmail(),
        'address'=>$s->getAddress(),
        ];
       }
    // return $this->json($data);
    return $this->render('supplier/index.html.twig', [
                 'sup' => $data
        ]);
    } 

      // Read One
    /**
     * @Route("/{id}", name="supp_show1", methods={"GET"})
     */
    public function readOneAction(Supplier $sup): Response
    {
    
       $data[] = 
       [
        'id'=>$sup->getId(), 
        'name'=>$sup->getName(), 
        'phone'=>$sup->getPhone(),
        'email'=>$sup->getEmail(),
        'address'=>$sup->getAddress(),
       ];
    
       return $this->render('supplier/index.html.twig', [
        'sup' => $data
]);

    } 

    /**
     * @Route("/supplier/add", name="suppAdd")
     */
    public function createAction(Request $req, SluggerInterface $slugger, SupplierRepository $repo): Response
    {
        
        $s = new Supplier();
        $formSupp = $this->createForm(SupplierType::class, $s);

        $formSupp->handleRequest($req);
        if($formSupp->isSubmitted() && $formSupp->isValid()){

            
            $repo->save($s,true);
            return $this->redirectToRoute('supp_show', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("supp_manage/index.html.twig",[
            'formSupp' => $formSupp->createView()
        ]);
    }
    

        /**
     * @Route("/edit/{id}", name="supp_edit")
     */
    public function editAction(Request $req, SluggerInterface $slugger, SupplierRepository $repo, Supplier $s): Response
    {
        $form = $this->createForm(SupplierType::class, $s);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            
            $repo->save($s,true);
            return $this->redirectToRoute('supp_page', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render("supp_manage/index.html.twig",[
            'form' => $form->createView()
        ]);
    }

    /**
     *  @Route("/delete/{id}", name="supp_delete", requirements={"id"="\d+"})
     */
    public function deleteAction(Request $req, Supplier $s): Response
    {
        $this->repo->remove($s,true);
        return $this->redirectToRoute('supp_page', [], Response::HTTP_SEE_OTHER);
    }
}


    // // Create a new one, add one
    // /**
    //  * @Route("/add", name="supp_add", methods={"POST"})
    //  */
    // public function addAction(Request $req): Response
    // {
    //     $s = new Supplier();
    //     $req = $this->transformJsonBody($req);
    //     $name = $req->get('name');
    //     $s->setName($name);
    //     $phone = $req->get('phone');
    //     if(isset($phone)) //kiểm tra có null hay không trong phone
    //     // if($phone === null)
    //     $s->setPhone($phone);
    //     else
    //     $s->setPhone(false);
    //     $this->repo->save($s, true);
    //     return $this->json($s->getId());
    // }

    // public function transformJsonBody(Request $re){
    //     $data = json_decode($re->getContent(), true);
    //     if($data === null){
    //         return $re;
    //     }
    //     $re->request->replace($data);
    //     return $re;
    // }

    //  // Edit one
    // /**
    //  * @Route("/edit/{id}", name="supp_edit", methods={"PUT"})
    //  */
    // public function editAction(Request $req, Supplier $s): Response
    // {
    //     // $s = new Supplier();
    //     $req = $this->transformJsonBody($req);
    //     $name = $req->get('name');
    //     $s->setName($name);
    //     $phone = $req->get('phone'); //bắt buộc
    //     $s->setPhone($$phone);
    //     $this->repo->add($s, true);
    //     return $this->json($s->getId());
    // }
     // Delete One
    // /**
    //  * @Route("/delete{id}", name="supp_del", methods={"DELETE"})
    //  */
    // public function delAction(Supplier $s): Response
    // {
    //     $this->repo->remove($s, true);
    //     return $this->json("Ukieee");
    // }