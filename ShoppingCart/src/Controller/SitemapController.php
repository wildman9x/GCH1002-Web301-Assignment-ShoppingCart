<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $urls = array();
        $hostname = $request->getSchemeAndHttpHost();
 
        // add static urls
        $urls[] = array('loc' => $this->generateUrl('home'));
        $urls[] = array('loc' => $this->generateUrl('edit_product'));
        $urls[] = array('loc' => $this->generateUrl('privacy_policy'));
         
        // add static urls with optional tags
        $urls[] = array('loc' => $this->generateUrl('fos_user_security_login'), 'changefreq' => 'monthly', 'priority' => '1.0');
        $urls[] = array('loc' => $this->generateUrl('cookie_policy'), 'lastmod' => '2018-01-01');
         
        // add dynamic urls, like blog posts from your DB
        foreach ($em->getRepository('BlogBundle:post')->findAll() as $post) {
            $urls[] = array(
                'loc' => $this->generateUrl('blog_single_post', array('post_slug' => $post->getPostSlug()))
            );
        }
 
        // add image urls
        $products = $em->getRepository('AppBundle:products')->findAll();
        foreach ($products as $item) {
            $images = array(
                'loc' => $item->getImagePath(), // URL to image
                'title' => $item->getTitle()    // Optional, text describing the image
            );
 
            $urls[] = array(
                'loc' => $this->generateUrl('single_product', array('slug' => $item->getProductSlug())),
                'image' => $images              // set the images for this product url
            );
        }
       
 
        // return response in XML format
        $response = new Response(
            $this->renderView('sitemap/sitemap.html.twig', array( 'urls' => $urls,
                'hostname' => $hostname)),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');
 
        return $response;
 
    }
}

