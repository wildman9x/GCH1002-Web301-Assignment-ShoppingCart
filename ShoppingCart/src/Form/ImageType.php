<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageID', FileType::class,
            [
                'label' => 'Lecturer image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getImageID())
                            //is_null : boolean
                            //if image is null => required = true
                            //else if image is not null => required = false
            ])
            ->add('productID', EntityType::class, [
                'label' => 'Product',
                'required' => true,
                'class' => Product::class,
                // combine productID and name in choice label
                'choice_label' => function ($product) {
                    return $product->getProductID() . ' - ' . $product->getName();
                },
                'multiple' => false,
                'expanded' => false
            ])
            ->add('save', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
