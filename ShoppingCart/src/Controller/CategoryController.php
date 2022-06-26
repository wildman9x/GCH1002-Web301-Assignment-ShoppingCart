<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'view_list_category')]
    public function CategoryIndex(CategoryRepository $categoryRepository)
    {
        $category= $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categorys' => $category
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_category')]
    public function CategoryDelete(CategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->find($id);
        if ($category= null) {
            $this->addFlash(
               'Error',
               'category not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash(
               'Success',
               'Delete category success !'
            );
        }
        return $this->redirectToRoute('view_list_category');
    }

    #[Route('/add/{id}', name: 'add_category')]
    public function CategoryAdd(CategoryRepository $categoryRepository, Request $request)
    {
        $category = new Category;
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash(
               'Success',
               'Add category success !'
            );
            return $this->redirectToRoute('view_list_category');
        }
        // return $this->render('category/add.html.twig',[
        //     'categoryForm'=>$form->createView()
        // ]);
    }
    #[Route('/edit/{id}', name: 'edit_category')]
    public function CategoryEdit(CategoryRepository $categoryRepository, $id, Request $request)
    {
        $category = $categoryRepository->find($id);
        if ($category= null) {
            $this->addFlash(
               'Error',
               'Category not found !'
            );
        } else {
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();
                $this->addFlash(
                   'success',
                   'Edit category success !'
                );
                return $this->redirectToRoute('view_list_category');
            }
    //     return $this->renderForm('category/edit.html.twig',
    // [
    //     'categoryForm'=> $form
    // ]);

        }
    }
}
