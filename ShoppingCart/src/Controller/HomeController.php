<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    // Get all products and picture from database and display them in home page
    // Use repository to get all products from database
    // get one random image for welcome message, 3 random images for banner
    public function index(ImageRepository $imageRepository, ProductRepository $productRepository)
    {
        $image = $imageRepository->findAll();
        $product = $productRepository->findAll();
        // get a random image from $image
        $randomImage = $imageRepository->findBy([], ['imageID' => 'ASC'], 1, 0);
        // get 3 random images from $image
        $randomImages = $imageRepository->findBy([], ['imageID' => 'ASC'], 3, 0);
        

        return $this->render('home/index.html.twig', [
            'images' => $image,
            'products' => $product,
            'randomImage' => $randomImage,
            'randomImages' => $randomImages
            
        ]);
    }
}
