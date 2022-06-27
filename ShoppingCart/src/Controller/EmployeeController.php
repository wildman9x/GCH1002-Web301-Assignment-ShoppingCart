<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\CustomerRepository;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/employee')]
class EmployeeController extends AbstractController
{
    #[Route('/', name: 'view_list_employee')]
    public function employeeIndex(EmployeeRepository $employeeRepository)
    {
        $employee = $employeeRepository->findAll();
        return $this->render('employee/index.html.twig', [
            'employees' => $employee
        ]);
    }

    
    #[Route('/detail/{id}', name: 'view_employee_by_id')]
    public function employeeDetail(EmployeeRepository $employeeRepository, $id)
    {
        $employee = $employeeRepository->find($id);
        return $this->render(
            "employee/detail.html.twig",
            [
                'employees' => $employee
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_employee')]
    public function employeeDelete(EmployeeRepository $employeeRepository, $id)
    {
        $employee = $employeeRepository->find(id);
        if ($employee == null) {
            $this->addFlash(
                'Error',
                'employee not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($employee);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete employee success !'
            );
        }
        return $this->redirectToRoute('view_list_employee');
    }

    #[Route('/add', name: 'add_employee')]
    public function employeeAdd(EmployeeRepository $employeeRepository, Request $request)
    {
        $employee = new Employee;
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($employee);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Add employee success !'
            );
            return $this->redirectToRoute('view_list_employee');
        }
              return $this->render('employee/add.html.twig',[
                 'employeeForm'=>$form->createView()
          ]);
    }
    #[Route('/edit/{id}', name: 'edit_employee')]
    public function customerEdit(EmployeeRepository $employeeRepository, $id,Request $request)
    {
        $employee = $employeeRepository->find($id);
        if ($employee == null) {
            $this->addFlash(
                'Error',
                'employee not found !'
            );
        } else {
            $form = $this->createForm(EmployeeType::class, $employee);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($employee);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Edit employee success !'
                );
                return $this->redirectToRoute('view_list_employee');
            }
                 return $this->renderForm('employee/edit.html.twig',
             [
                'employeeForm'=> $form
             ]);

        }
    }

     #[Route('/searchByName', name: 'search_employee_name')]
     public function SearchEmployeeName(EmployeeRepository $employeeRepository, Request $request)
     {
         $name = $request->get('keyword');
         $employee = $employeeRepository->searchByName($name);
         return $this->render('employee/index.html.twig', [
            'employees' => $employee
         ]);;
    }
}
