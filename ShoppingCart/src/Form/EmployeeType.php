<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EntityType::class,
                [
                    'label' => 'Email',
                    'class' => User::class,
                    'choice_label' => 'email',
                    'placeholder' => 'Choose an email',
                    'required' => true,
                    'expanded' => false,
                    'multiple' => false,
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
                'Position',
                TextType::class,
                [
                    'label' => 'Position'
                ]
            )


            ->add(
                'phone',
                TextType::class,
                [
                    'label' => 'Phone'
                ]

            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
