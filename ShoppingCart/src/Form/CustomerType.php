<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CustomerType extends Abstracttype
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
    //   ->add('email', EntityType::class ,
    // [
    //   'label' => 'Email',
    //   'required' => true,
    //   'class' => User::class
    // ])
    ->add('email', TextType::class, [
      'label' => 'Email',
      'constraints' => [
        new Length([
          'min' => 5,
          'max' => 255,
          'minMessage' => 'Your email must be at least {{ limit }} characters long',
          'maxMessage' => 'Your email cannot be longer than {{ limit }} characters',
        ]),
      ]
    ])
      ->add('name', TextType::class , [
      'label' => 'Name Custommer'
    ])

      ->add(
      'phoneNumber', TextType::class ,
    [
      'label' => 'Phone Number',
      'constraints' => [
        new Length([
          'max' => 10
        ])
      ],

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
