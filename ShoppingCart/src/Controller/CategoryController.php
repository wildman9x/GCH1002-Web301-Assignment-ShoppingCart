<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'view_list_category')]
    public function CategoryIndex(CategoryRepository $categoryRepository)
    {
        $categorys= $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categorys' => $categorys
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_category')]
    public function CategoryDelete(CategoryRepository $categoryRepository, $id)
    {
        $categorys = $categoryRepository->find(id);
        if ($categorys= null) {
            $this->addFlash(
               'Error',
               'category not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($categorys);
            $manager->flush();
            $this->addFlash(
               'Success',
               'Delete category success !'
            );
        }
        return $this->redirectToRoute('view_list_category');
    }

    #[Route('/add/{id}', name: 'add_category')]
    public function CategoryAdd(CategoryRepository $categoryRepository)
    {
        $categorys = new Category;
        $form = $this->createForm(CategoryType::class, $categorys);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($categorys);
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
    public function CategoryEdit(CategoryRepository $categoryRepository, $id)
    {
        $categorys = $categoryRepository->find(id);
        if ($categorys= null) {
            $this->addFlash(
               'Error',
               'Category not found !'
            );
        } else {
            $form = $this->createForm(CategoryType::class, $categorys);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) { 
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($categorys);
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
