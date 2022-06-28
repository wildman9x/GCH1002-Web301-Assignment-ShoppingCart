<?php

namespace App\Form;

use App\Entity\Image;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productID', TextType::class, [
                'label' => 'Product ID'
            ])
            ->add('catID', EntityType::class, [
                'label' => 'Category',
                'required' => true,
                // 'choices'=>array(
                //     'C01'=>'Bamboo',
                //     'C02'=> 'da'
                // ),
                'class' => Category::class,
                // combination of catID and name in choice label
                'choice_label' => function ($cat) {
                    return $cat->getCatID() . ' - ' . $cat->getName();
                },
                'multiple' => false,
                'expanded' => false
            ])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Name Product'
                ]
            )
            // add price that accept a float type
            ->add(
                'price',
                NumberType::class,
                [
                    'label' => 'Price',
                    'attr' => [
                        'min' => 0,
                        'max' => 300
                    ]

                ]
            )
            ->add(
                'info',
                TextType::class,
                [
                    'label' => 'Information'
                ]
            )
            // ->add('images', EntityType::class, [
            //     'label' => 'images',
            //     'required' => true,
            //     'class' => Image::class,
            //     'choice_label' => 'images',
            //     'multiple' => true,
            //     'expanded' => false
            // ])
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
