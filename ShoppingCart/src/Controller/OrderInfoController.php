<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderInfoController extends AbstractController
{
    #[Route('/order/info', name: 'app_order_info')]
    public function index(): Response
    {
        return $this->render('order_info/index.html.twig', [
            'controller_name' => 'OrderInfoController',
        ]);
    }
}
