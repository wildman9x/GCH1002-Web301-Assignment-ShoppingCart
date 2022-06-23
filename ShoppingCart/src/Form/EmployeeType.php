<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'Numberphone',
                IntergerType::class,
                [
                    'label' => 'Numberphone',
                    'attr' => [
                        'min' => 10,
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
