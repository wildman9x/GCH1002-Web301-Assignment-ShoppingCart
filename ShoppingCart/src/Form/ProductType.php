<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Name Product'
            ])
            ->add('price', FloatType::class,
            [
                'label' =>'Price',
                'attr' => [
                    'min'=>0,
                    'max'=>300
                ]

            ])
            ->add('info', TextType::class,
            [
                'label'=>'Information'
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
