<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// route to homepage
#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'view_list_product')]
    public function ProductIndex(ProductRepository $productRepository)
    {
        $product = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $product
        ]);
    }

    #[Route('/detail/{id}', name: 'view_product_by_id')]
    public function ProductDetail(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        return $this->render(
            "product/detail.html.twig",
            [
                'products' => $product
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_product')]
    public function ProductDelete(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        if ($product = null) {
            $this->addFlash(
                'Error',
                'product not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete product success !'
            );
        }
        return $this->redirectToRoute('view_list_product');
    }

    #[Route('/add', name: 'add_product')]
    public function ProductAdd(ProductRepository $productRepository, Request $request)
    // {
    //     $product = new Product();
    //     $form = $this->createFormBuilder($product)
    //         ->add('name')
    //         ->add('price')
    //         ->add('description')
    //         ->add('image')
    //         ->add('save', SubmitType::class, ['label' => 'Add Product'])
    //         ->getForm();
    //     $form->handleRequest($request);
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Add product success !'
            );
            return $this->redirectToRoute('view_list_product');
        }
        return $this->render('product/add.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
    #[Route('/edit/{id}', name: 'edit_product')]
    public function ProductEdit(ProductRepository $productRepository, $id, Request $request)
    {
        $product = $productRepository->find($id);
        if ($product = null) {
            $this->addFlash(
                'Error',
                'product not found !'
            );
        } else {
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Edit product success !'
                );
                return $this->redirectToRoute('view_list_product');
            }
            return $this->renderForm(
                'product/edit.html.twig',
                [
                    'productForm' => $form
                ]
            );
        }
    }

    #[Route('/searchByName', name: 'search_product_name')]
    public function SearchProductName(ProductRepository $productRepository, Request $request)
    {
        $name = $request->get('% keyword %');
        $product = $productRepository->searchByName($name);
        return $this->render('product/index.html.twig', [
            'prodcuts' => $product
        ]);;
    }
}
