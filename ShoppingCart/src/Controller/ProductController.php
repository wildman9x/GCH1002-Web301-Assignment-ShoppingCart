<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// route to homepage
#[Route('/product')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'view_list_product')]
    public function ProductIndex(ProductRepository $productRepository)
    {
        $products= $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_product')]
    public function ProductDelete(ProductRepository $productRepository, $id)
    {
        $products = $productRepository->find(id);
        if ($products= null) {
            $this->addFlash(
               'Error',
               'product not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($products);
            $manager->flush();
            $this->addFlash(
               'Success',
               'Delete product success !'
            );
        }
        return $this->redirectToRoute('view_list_product');
    }

    #[Route('/add/{id}', name: 'add_product')]
    public function ProductAdd(ProductRepository $productRepository)
    {
        $products = new Product;
        $form = $this->createForm(ProductType::class, $products);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($products);
            $manager->flush();
            $this->addFlash(
               'Success',
               'Add product success !'
            );
            return $this->redirectToRoute('view_list_product');
        }
        // return $this->render('category/add.html.twig',[
        //     'categoryForm'=>$form->createView()
        // ]);
    }
    #[Route('/edit/{id}', name: 'edit_product')]
    public function ProductEdit(ProductRepository $productRepository, $id)
    {
        $products = $productRepository->find(id);
        if ($products= null) {
            $this->addFlash(
               'Error',
               'product not found !'
            );
        } else {
            $form = $this->createForm(ProductType::class, $categorys);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($products);
                $manager->flush();
                $this->addFlash(
                   'success',
                   'Edit product success !'
                );
                return $this->redirectToRoute('view_list_product');
            }
    //     return $this->renderForm('category/edit.html.twig',
    // [
    //     'categoryForm'=> $form
    // ]);

        }
    }

    #[Route('/searchByName', name: 'search_product_name')]
    public function SearchProductName(ProductRepository $productRepository, Request $request)
    {
        $name = $request->get('% keyword %');
        $products = $productRepository-> searchByName($name);
        return $this->render('product/index.html.twig',[
            'prodcuts' => $products
        ]);;
    }
}