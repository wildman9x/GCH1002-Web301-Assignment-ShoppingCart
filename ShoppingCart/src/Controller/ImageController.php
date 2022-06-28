<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
/**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route('/admin')]
class ImageController extends AbstractController
{
    #[Route('/image', name: 'image_index')]
    public function index(ImageRepository $imageRepository)
    {
        $image = $imageRepository->findAll();
        return $this->render('image/index.html.twig', [
            'images' => $image
        ]);
    }

    #[Route('/image/detail/{id}', name: 'image_detail')]
    public function detail(ImageRepository $imageRepository, $id)
    {
        $image = $imageRepository->find($id);
        return $this->render('image/detail.html.twig', [
            'images' => $image
        ]);
    }

    #[Route('/image/delete/{id}', name: 'image_delete')]
    public function delete(ImageRepository $imageRepository, $id)
    {
        $image = $imageRepository->find($id);
        if ($image == null) {
            $this->addFlash(
                'Error',
                'image not found !'
            );
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($image);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Delete image success !'
            );
        }
        return $this->redirectToRoute('image_index');
    }

    #[Route('/image/add', name: 'image_add')]
    public function add(ImageRepository $imageRepository, Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageID')->getData();
            $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('product_image'),
                $fileName
            );
            $image->setImageID($fileName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($image);
            $manager->flush();
            $this->addFlash(
                'Success',
                'Add image success !'
            );
            return $this->redirectToRoute('image_index');
        }
        return $this->render('image/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // edit image
    #[Route('/image/edit/{id}', name: 'image_edit')]
    public function edit(ImageRepository $imageRepository, ManagerRegistry $managerRegistry, Request $request, $id)
    {
        $image = $managerRegistry->getRepository(Image::class)->find($id);
        if ($image == null) {
            $this->addFlash("Error","Image not found !");
            return $this->redirectToRoute("image_index");        
        } else {
            $form = $this->createForm(ImageType::class,$image);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //kiểm tra xem người dùng có muốn upload ảnh mới hay không
                //nếu có thì thực hiện code upload ảnh
                //nếu không thì bỏ qua
                $imageFile = $form['imageID']->getData();
                if ($imageFile != null) {
                    
                    $imageData = $image->getImageID();
                    $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
                    try {
                        $imageFile->move(
                            $this->getParameter('product_image'),
                            $imageName
                        );
                    } catch (FileException $e) {
                        throwException($e);
                    }
                    
                    $image->setImageID($imageName);
                }
                $manager = $managerRegistry->getManager();
                $manager->persist($image);
                $manager->flush();
                $this->addFlash("Success","Edit image succeed !");
                return $this->redirectToRoute("image_index");
            }
        return $this->render('image/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    }
}
