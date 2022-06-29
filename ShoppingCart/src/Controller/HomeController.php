<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    // Get all products and picture from database and display them in home page
    // Use repository to get all products from database
    // get one random image for welcome message, 3 random images for banner
    public function index(ImageRepository $imageRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $image = $imageRepository->findAll();
        $product = $productRepository->findAll();
        // get a random image from $image
        $randomImage = $imageRepository->findBy([], ['imageID' => 'ASC'], 1, 0);
        // get 3 random images from $image
        $randomImages = $imageRepository->findBy([], ['imageID' => 'ASC'], 3, 0);
        $category = $categoryRepository->findAll();
        

        return $this->render('home/index.html.twig', [
            'images' => $image,
            'products' => $product,
            'randomImage' => $randomImage,
            'randomImages' => $randomImages,
            'categories' => $category
            
        ]);
    }

    // display product detail for user
    #[Route('/product/detail/{id}', name: 'product_detail')]
    public function productDetail(ProductRepository $productRepository, CategoryRepository $categoryRepository, $id)
    {
        $product = $productRepository->find($id);
        $category = $categoryRepository->findAll();
        return $this->render('home/detail.html.twig', [
            'product' => $product,
            'categories' => $category
        ]);
    }

    // search for products by name
    #[Route('/product/search', name: 'product_search')]
    public function productSearch(ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, Request $request)
    {
        $search = $request->query->get('search');
        $product = $productRepository->searchByName($search);
        $image = $imageRepository->findAll();
        $category = $categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $product,
            'categories' => $category,
            'images' => $image
        ]);
    }

    // add an item to user's cart
    // if user is not logged in, redirect to login page
    // if user is logged in, add item to cart and redirect to cart page
    // if cart doesn't exist, create a new cart
    #[Route('/product/add/{id}', name: 'product_add_cart')]
    public function productAdd(ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, Request $request, $id)
    {
        $product = $productRepository->find($id);
        $category = $categoryRepository->findAll();
        $image = $imageRepository->findAll();
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('login');
        } else {
            $cart = $user->getCustomer()->getCart();
            if ($cart == null) {
                $cart = new Cart();
                // set quantity to 0
                $cart->setQuantity(0);
                $user->getCustomer()->setCart($cart);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
            }
            // if item is already in cart, increase quantity
            if ($cart->getProductID() == $product->getProductID()) {
                $cart->addQuantity();
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($cart);
                $manager->flush();
            } else {
                $cart->addProductID($product);
                $cart->setQuantity(1);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($cart);
                $manager->flush();
            }
            // $manager = $this->getDoctrine()->getManager();
            // $manager->persist($cart);
            // $manager->flush();
            return $this->redirectToRoute('cart');
        }
    }

    // display user's cart
    // if user is not logged in, redirect to login page
    // if user is logged in, display cart
    #[Route('/home/cart', name: 'cart')]
    public function cart(ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, Request $request)
    {
        $user = $this->getUser();
        
        if ($user == null) {
            return $this->redirectToRoute('login');
        } else {
            
            
            $cart = $user->getCustomer()->getCart();
            $product = $productRepository->findAll();
            $image = $imageRepository->findAll();
            $category = $categoryRepository->findAll();
            // get all products in the cart, calculate subtotal by multiplying quantity by price
            $subtotal = 0;
            foreach ($cart->getProductID() as $productTemp) {
                $subtotal += $productTemp->getPrice() * $cart->getQuantity();
            }

            return $this->render('home/cart.html.twig', [
                'cart' => $cart,
                'products' => $product,
                'categories' => $category,
                'images' => $image,
                'subtotal' => $subtotal
            ]);
        }
    }

    // increase quantity by one ưhen the plus button is clicked
    #[Route('/product/increase/{id}', name: 'product_increase_quantity')]
    public function productIncreaseQuantity(ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, Request $request, $id)
    {
        
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('login');
        } else {
            $cart = $user->getCustomer()->getCart();
            $product = $productRepository->find($id);
            $cart->addProductID($product);
            $cart->addQuantity();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cart);
            $manager->flush();
            return $this->redirectToRoute('cart');
        }
    }
    

    // decrease quantity by one when the minus button is clicked, if the quantity is 1, remove the item from cart
    #[Route('/product/decrease/{id}', name: 'product_decrease_quantity')]
    public function productDecreaseQuantity(ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, Request $request, $id)
    {
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('login');
        } else {
            $cart = $user->getCustomer()->getCart();
            $product = $productRepository->find($id);
            $cart->addProductID($product);
            $cart->removeQuantity();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($cart);
            $manager->flush();
            // if quantity is 0, remove the product using removeProduct
            if ($cart->getQuantity() == 0) {
                $cart->removeProduct($product);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($cart);
                $manager->flush();
                
            }
            return $this->redirectToRoute('cart');
        }
    }

}
