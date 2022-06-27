<?php

namespace App\Controller;

use App\Entity\OrderInfo;
use App\Repository\OrderInfoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/orderInfo')]
class OrderInfoController extends AbstractController
{
    #[Route('/', name: 'view_list_orderInfo')]
    public function orderInfoIndex(OrderInfoRepository $orderInfoRepository)
    {
        $orderInfo = $orderInfoRepository->findAll();
        return $this->render('orderInfo/index.html.twig', [
            'orderInfos' => $orderInfo
        ]);
    }

    
    #[Route('/detail/{id}', name: 'view_orderInfo_by_id')]
    public function orderInfoDetail(OrderInfoRepository $orderInfoRepository, $id)
    {
        $orderInfo = $orderInfoRepository->find($id);
        return $this->render(
            "orderInfo/detail.html.twig",
            [
                'orderInfos' => $orderInfo
            ]
        );
    }

    #[Route('/delete/{id}', name: 'delete_orderInfo')]
    public function orderInfoDelete(OrderInfoRepository $orderInfoRepository, $id)
    {
        $orderInfo = $orderInfoRepository->find($id);
        if ($orderInfo = null) {
            $this->addFlash(
                'Error',
                'orderInfo not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($orderInfo);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete orderInfo success !'
            );
        }
        return $this->redirectToRoute('view_list_orderInfo');
    }

    #[Route('/add', name: 'add_orderInfo')]
    public function orderInfoAdd(OrderInfoRepository $orderInfoRepository, Request $request)
    {
        $orderInfo = new OrderInfo;
        $form = $this->createForm(OrderInfoType::class, $orderInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($orderInfo);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Add orderInfo success !'
            );
            return $this->redirectToRoute('view_list_orderInfo');
        }
        //      return $this->render('customer/add.html.twig',[
        //         'customerForm'=>$form->createView()
        //  ]);
    }
    #[Route('/edit/{id}', name: 'edit_orderInfo')]
    public function customerEdit(OrderInfoRepository $orderInfoRepository, $id, Request $request)
    {
        $orderInfo = $orderInfoRepository->find($id);
        if ($orderInfo = null) {
            $this->addFlash(
                'Error',
                'orderInfo not found !'
            );
        } else {
            $form = $this->createForm(OrderInfoType::class, $orderInfo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($orderInfo);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Edit orderInfo success !'
                );
                return $this->redirectToRoute('view_list_orderInfo');
            }
            //     return $this->renderForm('category/edit.html.twig',
            // [
            //     'categoryForm'=> $form
            // ]);

        }
    }

    //  #[Route('/searchByName', name: 'search_orderInfo_name')]
    //  public function SearchOrderInfo(OrderInfoRepository $orderInfoRepository, Request $request)
    //  {
    //      $name = $request->get('% keyword %');
    //      $orderInfo = $orderInfoRepository->searchByName($name);
    //      return $this->render('orderInfo/index.html.twig', [
    //         'orderInfos' => $orderInfo
    //      ]);;
    // }
}
