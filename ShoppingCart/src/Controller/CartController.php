<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;
use App\Repository\CustomerRepository;
use Symfony\Component\BrowserKit\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cart')]
class CartController extends AbstractController
{
     
    #[Route('/', name: 'view_list_cart')]
    public function cartIndex(CartRepository $cartRepository)
    {
        $cart = $cartRepository->findAll();
        return $this->render('cart/index.html.twig', [
            'carts' => $cart
        ]);
    }

    
    #[Route('/detail/{id}', name: 'view_cart_by_id')]
    public function cartDetail(CartRepository $cartRepository, $id)
    {
        $cart = $cartRepository->find($id);
        return $this->render(
            "cart/detailSys.html.twig",
            [
                'carts' => $cart
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_cart')]
    public function ccartDelete(CartRepository $cartRepository, $id)
    {
        $cart = $cartRepository->find($id);
        // if ($cart == null) {
        //     $this->addFlash(
        //         'Error',
        //         'cart not found !'
        //     );
        // } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($cart);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete cart success !'
            );
        // }
        return $this->redirectToRoute('view_list_cart');
    }

    // #[Route('/add/{id}', name: 'add_cart')]
    // public function cartAdd(CartRepository $cartRepository)
    // {
    //     $cart = new Cart;
    //     $form = $this->createForm(CartType::class, $cart);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($cart);
    //         $manager->flush();
    //         $this->addFlash(
    //             'Success',
    //             'Add cart success !'
    //         );
    //         return $this->redirectToRoute('view_list_cart');
    //     }
    //     //      return $this->render('customer/add.html.twig',[
    //     //         'customerForm'=>$form->createView()
    //     //  ]);
    // }
    #[Route('/edit/{id}', name: 'edit_cart')]
    public function customerEdit(CartRepository $cartRepository, $id, Request $request)
    {
        $cart = $cartRepository->find($id);
        if ($cart = null) {
            $this->addFlash(
                'Error',
                'cart not found !'
            );
        } else {
            $form = $this->createForm(CartType::class, $cart);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($cart);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Edit cart success !'
                );
                return $this->redirectToRoute('view_list_cart');
            }
                 return $this->renderForm('cart/edit.html.twig',
             [
                 'cartForm'=> $form
             ]);

        }
    }

    // #[Route('/searchByName', name: 'search_customer_name')]
    // public function SearchCustomerName(CustomerRepository $customerRepository, Request $request)
    // {
    //     $name = $request->get('% keyword %');
    //     $customer = $customerRepository->searchByName($name);
    //     return $this->render('customer/index.html.twig', [
    //         'customers' => $customer
    //     ]);;
    // }
}
