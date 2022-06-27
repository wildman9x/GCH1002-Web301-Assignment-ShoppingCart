<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email')
            ->add(

                'email',
                EntityType::class,
                [
                    'label' => 'Email',
                    'class' => User::class,

                ]
            )
            ->add(
                'name',
                TextType::class,

                [
                    'label' => 'Email',
                    'class' => User::class,

                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Name Employee'
                ]
            )




            ->add(
            'position',
            TextType::class ,
        [
            'label' => 'Position'
        ]
        )
            ->add(
            'phone',
            TextType::class ,
        [
            'label' => 'Number phone',
            'attr' => [
                'max' => 10
            ]
        ]
        )
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
