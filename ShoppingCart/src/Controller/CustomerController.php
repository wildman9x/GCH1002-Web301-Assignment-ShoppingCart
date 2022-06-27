<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


#[Route('/customer')]
class CustomerController extends AbstractController
{

    #[Route('/', name: 'view_list_customer')]
    public function customerIndex(CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->findAll();
        return $this->render('customer/index.html.twig', [
            'customers' => $customer
        ]);
    }

    #[Route('/detail/{id}', name: 'view_customer_by_id')]
    public function customertDetail(CustomerRepository $customerRepository, $id)
    {
        $customer = $customerRepository->find($id);
        return $this->render(
            "customer/detail.html.twig",
            [
                'customers' => $customer
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_customer')]
    public function customerDelete(CustomerRepository $customerRepository, $id)
    {
        $customer = $customerRepository->find($id);
        if ($customer = null) {
            $this->addFlash(
                'Error',
                'customer not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($customer);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete customer success !'
            );
        }
        return $this->redirectToRoute('view_list_product');
    }

    #[Route('/add', name: 'add_customer')]
    public function customerAdd(CustomerRepository $customerRepository, Request $request)
    {
        $customer = new Customer;
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($customer);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Add customer success !'
            );
            return $this->redirectToRoute('view_list_customer');
        }
              return $this->render('customer/add.html.twig',[
                 'customerForm'=>$form->createView()
          ]);
    }
    #[Route('/edit/{id}', name: 'edit_customer')]
    public function customerEdit(CustomerRepository $customerRepository, $id, Request $request)
    {
        $customer = $customerRepository->find($id);
        if ($customer = null) {
            $this->addFlash(
                'Error',
                'customer not found !'
            );
        } else {
            $form = $this->createForm(CustomerType::class, $customer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($customer);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Edit customer success !'
                );
                return $this->redirectToRoute('view_list_customer');
            }
                 return $this->renderForm('customer/edit.html.twig',
             [
                 'customerForm'=> $form
             ]);

        }
    }

    #[Route('/searchByName', name: 'search_customer_name')]
    public function SearchCustomerName(CustomerRepository $customerRepository, Request $request)
    {
        $name = $request->get('% keyword %');
        $customer = $customerRepository->searchByName($name);
        return $this->render('customer/index.html.twig', [
            'customers' => $customer
        ]);;
    }
}
